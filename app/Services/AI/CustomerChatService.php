<?php

namespace App\Services\AI;


use App\Models\Category;
use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Repositories\ProductRepository;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class CustomerChatService
{
    /**
     * The constructor uses PHP 8+ property promotion.
     * The repository is injected and becomes a readonly property of the class.
     */
    public function __construct(
        protected readonly ProductRepository $productRepository
    ) {}

    /**
     * Handles the entire user interaction flow in a unified way.
     * 1. Extract filters from the user query.
     * 2. Searches for products if filters are present.
     * 3. Passes product context (or empty context) to the LLM for final response generation.
     * 4. Saves the conversation.
     *
     * @param string $message
     * @param Request $request
     * @return string
     */
    public function handleUserMessage(string $message, Request $request): string
    {
        if (! auth()->check()) {
            return '🔒 You must be logged in to use the assistant.';
        }

        $userId = auth()->id();
        $conversation = Conversation::firstOrCreate(['user_id' => $userId]);

        // Store the user's message first
        ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender' => 'user',
            'message' => $message,
        ]);

        // Prepare conversation history for the AI
        $history = $this->getConversationHistory($conversation->id);

        // --- NEW UNIFIED FLOW ---

        try {
            $filters = $this->analyzeMessageForFilters($history);

            $products = collect(); // Initialize an empty collection
            $productContext = '';

            if ($this->hasSearchFilters($filters)) {
                $products = $this->productRepository->searchByFilters($filters);
                $productContext = $this->buildProductContextForAI($products);
            }

            // 3. Generate the final, intelligent response from the LLM, providing all context
            $finalReply = $this->generateFinalResponse($history, $productContext, $products);


            // 4. Save the final AI reply once
            ChatMessage::create([
                'conversation_id' => $conversation->id,
                'sender' => 'assistant',
                'message' => $finalReply,
            ]);

            return $finalReply;

        } catch (Exception $e) {
            Log::error('CustomerChatService handleUserMessage Exception: ' . $e->getMessage());
            return '⚠️ An error occurred while trying to respond. Please try again later.';
        }
    }

    /**
     * Fetches and formats the last messages for AI context.
     *
     * @param int $conversationId
     * @return array
     */
    private function getConversationHistory(int $conversationId): array
    {
        return ChatMessage::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->reverse() // Reverse to get chronological order
            ->map(fn($msg) => ['role' => $msg->sender === 'user' ? 'user' : 'assistant', 'content' => $msg->message])
            ->values()
            ->toArray();
    }


    /**
     * Uses an LLM to extract structured search filters from conversation history.
     * This version is improved by providing the LLM with a list of valid categories.
     *
     * @param array $messages
     * @return array
     */

    private function analyzeMessageForFilters(array $messages): array
    {
        // Fetch the list of valid category names from your database.
        $validCategories =Category::pluck('name')->toArray();
        $validCategoriesString = implode('", "', $validCategories);

        $systemPrompt = <<<PROMPT
You are a highly accurate JSON extraction tool for an e-commerce store. Analyze the user's LATEST message and extract search filters into a valid JSON object.
The possible JSON keys are: "category", "keywords", "min_price", "max_price", "technical_specs".

**CRITICAL RULES:**
1. The value for the "category" key MUST EXACTLY MATCH one of the following valid categories if the user mentions one: ["{$validCategoriesString}"].
2. If the user asks a general question (e.g., "what is the best programming language?"), return an empty JSON object {}.
3. Your response MUST BE ONLY a valid JSON object and nothing else.

--- EXAMPLES ---

- User Query: "are there any gaming laptops with 16gb ram"
- Your JSON:
{
    "category": "Laptops",
    "keywords": ["gaming"],
    "technical_specs": { "ram": "16gb" }
}

- User Query: "show me something for under 500 dollars"
- Your JSON:
{
    "max_price": 500
}

- User Query: "what about phones that cost more than $300"
- Your JSON:
{
    "category": "Phones",
    "min_price": 300
}


- User Query: "do you have an iPhone 14 Pro I'm looking for it"
- Your JSON:
{
    "keywords": ["iPhone 14 Pro", "iPhone", "14"]
}
// --- END OF NEW EXAMPLES ---

PROMPT;

        $response = $this->callOpenRouter(
            model: 'openai/gpt-3.5-turbo',
            systemPrompt: $systemPrompt,
            messages: $messages,
            temperature: 0.0,
            forceJson: true
        );

        $decoded = json_decode($response, true);
        return is_array($decoded) ? $decoded : [];
    }
    /**
     * Generates the final, natural-language response for the user.
     *
     * @param array $history
     * @param string $productContext
     * @return string
     * @throws RequestException
     */
    private function generateFinalResponse(array $history, string $productContext,\Illuminate\Support\Collection $products): string
    {
        $systemPrompt = <<<PROMPT
You are 'Smart Assistant', a friendly and expert AI for an online electronics store. Your replies MUST be in ENGLISH.

- If the CONTEXT contains product information, use it to answer the user's question. Present the products attractively.
- The CONTEXT for each product includes a pre-formatted Markdown link, for example: '[See more details](http://.../url)'. When you mention a product, you MUST include this exact link in your response. Do not just talk about the link, include the full Markdown link itself.
- If the CONTEXT says no products were found, politely inform the user.
- If the user asks a general question, answer it clearly.
- NEVER make up products or prices. Rely ONLY on the provided CONTEXT.
PROMPT;

        if ($products->count() > 3) {
            $systemPrompt .= "\n- The user's search returned many results. After presenting 2-3 options, you MUST ask a clarifying question to help them narrow down the search (e.g., ask about their budget, preferred brand, or specific features).";
        }

        $finalSystemPrompt = "CONTEXT:\n" . ($productContext ?: 'No specific products were requested or found.') . "\n\n" . $systemPrompt;

        return $this->callOpenRouter(
            model: 'openai/gpt-3.5-turbo',
            systemPrompt: $finalSystemPrompt,
            messages: $history,
            temperature: 0.5);
    }

    /**
     * A centralized, reusable method for making API calls to OpenRouter.
     *
     * @param string $model
     * @param string $systemPrompt
     * @param array $messages
     * @param float $temperature
     * @param bool $forceJson
     * @return string
     * @throws RequestException|ConnectionException
     */
    private function callOpenRouter(string $model, string $systemPrompt, array $messages, float $temperature, bool $forceJson = false): string
    {
        $payload = [
            'model' => $model,
            'messages' => array_merge([['role' => 'system', 'content' => $systemPrompt]], $messages),
            'temperature' => $temperature,
        ];

        if ($forceJson) {
            $payload['response_format'] = ['type' => 'json_object'];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openrouter.key'),
        ])->timeout(30)->post('https://openrouter.ai/api/v1/chat/completions', $payload);

        // This will automatically throw an exception if the request fails (e.g., 4xx or 5xx response)
        $response->throw();

        return $response->json('choices.0.message.content', 'Sorry, I could not process the response.');
    }

    /**
     * Builds a string of product information for the AI context.
     *
     * @param Collection $products
     * @return string
     */
    private function buildProductContextForAI(Collection $products): string
    {
        if ($products->isEmpty()) {
            return "No products matching the user's request were found in the database.";
        }
        $context = "The following products were found in the database that match the user's request:\n";
        foreach ($products as $product) {
            $price = $product->sale_price ?? $product->regular_price;
            $stock = $product->quantity > 0 ? "In Stock ({$product->quantity})" : "Out of Stock";

            // --- THE NEW, MORE ROBUST APPROACH ---
            // 1. Generate the full URL for the product
            $url = route('product.details', ['slug' => $product->slug]);

            // 2. Make the product's name itself the Markdown link.
            // This is much harder for the AI to ignore or separate.
            $linkedName = "[{$product->name}]({$url})";
            // --- END OF NEW APPROACH ---

            // Append the formatted line with the new linked name.
            $context .= "- Product: {$linkedName}, Price: " . number_format((float)$price, 2) . " SAR, Availability: {$stock}\n";
        }
        return $context;
    }



    /**
     * Simple check to see if the filters array contains any searchable values.
     * This remains the same as your version.
     */
    protected function hasSearchFilters(array $filters): bool
    {
        // Remove empty values from the array recursively
        $filtered = array_filter(Arr::except($filters, ['']));
        return !empty($filtered);
    }

    /**
     * Public method to fetch conversation history specifically for the frontend UI.
     * It returns the data in the format expected by the UI.
     *
     * @param int $conversationId
     * @return Collection
     */
    public function getHistoryForFrontend(int $conversationId): Collection
    {
        return ChatMessage::where('conversation_id', $conversationId)
            ->orderBy('created_at')
            ->get(['sender', 'message', 'created_at']);
    }

// ... (The rest of your service class)

}
