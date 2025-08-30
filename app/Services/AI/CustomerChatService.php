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

/**
 * Class CustomerChatService
 *
 * Handles the AI-powered customer assistant workflow:
 * - Stores and retrieves chat messages in conversations.
 * - Analyzes user queries to extract structured search filters.
 * - Searches products in the database based on extracted filters.
 * - Builds product context and interacts with an LLM (via OpenRouter) to generate responses.
 * - Returns conversation history for frontend display.
 */
class CustomerChatService
{
    /**
     * CustomerChatService constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(
        protected readonly ProductRepository $productRepository
    ) {}

    /**
     * Main entry point for handling user messages.
     * - Validates authentication.
     * - Stores user message.
     * - Prepares conversation history.
     * - Extracts filters and searches products.
     * - Calls LLM for generating the assistant's response.
     * - Persists the assistant's reply.
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

        ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender' => 'user',
            'message' => $message,
        ]);

        $history = $this->getConversationHistory($conversation->id);

        try {
            $filters = $this->analyzeMessageForFilters($history);

            $products = collect();
            $productContext = '';

            if ($this->hasSearchFilters($filters)) {
                $products = $this->productRepository->searchByFilters($filters);
                $productContext = $this->buildProductContextForAI($products);
            }

            $finalReply = $this->generateFinalResponse($history, $productContext, $products);

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
     * Fetches the last 5 conversation messages (user + assistant) in chronological order.
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
            ->reverse()
            ->map(fn($msg) => [
                'role' => $msg->sender === 'user' ? 'user' : 'assistant',
                'content' => $msg->message
            ])
            ->values()
            ->toArray();
    }

    /**
     * Uses an LLM to analyze conversation history and extract search filters (JSON).
     *
     * @param array $messages
     * @return array
     */
    private function analyzeMessageForFilters(array $messages): array
    {
        $validCategories = Category::pluck('name')->toArray();
        $validCategoriesString = implode('", "', $validCategories);

        $systemPrompt = <<<PROMPT
You are a highly accurate JSON extraction tool for an e-commerce store...
[... trimmed for brevity ...]
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
     * Generates a final assistant response using product context + chat history.
     *
     * @param array $history
     * @param string $productContext
     * @param Collection $products
     * @return string
     * @throws RequestException
     */
    private function generateFinalResponse(array $history, string $productContext, Collection $products): string
    {
        $systemPrompt = <<<PROMPT
You are 'Smart Assistant', a friendly and expert AI for an online electronics store...
PROMPT;

        if ($products->count() > 3) {
            $systemPrompt .= "\n- Too many results found. Ask clarifying questions...";
        }

        $finalSystemPrompt = "CONTEXT:\n" . ($productContext ?: 'No specific products were requested or found.') . "\n\n" . $systemPrompt;

        return $this->callOpenRouter(
            model: 'openai/gpt-3.5-turbo',
            systemPrompt: $finalSystemPrompt,
            messages: $history,
            temperature: 0.5
        );
    }

    /**
     * Generic helper to call OpenRouter API for LLM interaction.
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

        $response->throw();

        return $response->json('choices.0.message.content', 'Sorry, I could not process the response.');
    }

    /**
     * Builds product details string context for the AI model.
     *
     * @param Collection $products
     * @return string
     */
    private function buildProductContextForAI(Collection $products): string
    {
        if ($products->isEmpty()) {
            return "No products matching the user's request were found in the database.";
        }

        $context = "The following products were found:\n";
        foreach ($products as $product) {
            $price = $product->sale_price ?? $product->regular_price;
            $stock = $product->quantity > 0 ? "In Stock ({$product->quantity})" : "Out of Stock";
            $url = route('product.details', ['slug' => $product->slug]);
            $linkedName = "[{$product->name}]({$url})";

            $context .= "- Product: {$linkedName}, Price: " . number_format((float)$price, 2) . " SAR, Availability: {$stock}\n";
        }

        return $context;
    }

    /**
     * Checks if extracted filters contain any valid search criteria.
     *
     * @param array $filters
     * @return bool
     */
    protected function hasSearchFilters(array $filters): bool
    {
        $filtered = array_filter(Arr::except($filters, ['']));
        return !empty($filtered);
    }

    /**
     * Returns the conversation history formatted for frontend UI display.
     *
     * @param int|null $conversationId
     * @return Collection
     */
    public function getHistoryForFrontend(? int $conversationId =null): Collection
    {
        if(!$conversationId){
            $userId = auth()->id();
            $conversation = Conversation::firstOrCreate([
                'user_id' => $userId,
            ]);
$conversationId=$conversation->id;
        }



        return ChatMessage::where('conversation_id', $conversationId)
            ->orderBy('created_at')
            ->get(['sender', 'message', 'created_at']);
    }
}
