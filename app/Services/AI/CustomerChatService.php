<?php
namespace App\Services\AI;

use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerChatService
{
protected ProductRepository $productRepository;

public function __construct(ProductRepository $productRepository)
{
$this->productRepository = $productRepository;
}

/**
* Handle a user message: store it, analyze it, get product matches, and generate a response.
*/
public function handleUserMessage(string $message, Request $request): string
{
// ✅ 1. Get or create a conversation based on the logged-in user
if (!auth()->check()) {
return '🔒 You must be logged in to chat with the assistant.';
}

$userId = auth()->id();

$conversation = Conversation::firstOrCreate([
'user_id' => $userId,
]);

// ✅ 2. Store the user's message
ChatMessage::create([
'conversation_id' => $conversation->id,
'sender' => 'user',
'message' => $message,
]);

// ✅ 3. Retrieve the last 10 messages from the same conversation for context
$history = ChatMessage::where('conversation_id', $conversation->id)
->orderBy('created_at')
->take(10)
->get();

$messages = $history->map(function ($msg) {
return [
'role' => $msg->sender === 'user' ? 'user' : 'assistant',
'content' => $msg->message,
];
})->toArray();

// ✅ 4. Analyze user message to extract filters
$filters = $this->analyzeMessage($messages);

// ✅ 5. Search for products using extracted filters
$products = $this->productRepository->searchByFilters($filters);

// ✅ 6. Generate assistant's reply
$reply = $this->generateResponse($message, $products);

// ✅ 7. Store the assistant's reply
ChatMessage::create([
'conversation_id' => $conversation->id,
'sender' => 'assistant',
'message' => $reply,
]);

return $reply;
}

/**
* Analyze the user's message using OpenRouter to extract structured filters.
*/
protected function analyzeMessage(array $messages): array
{
$systemPrompt = "You are a helpful and polite AI assistant for an electronics e-commerce store.
You assist users with product recommendations, comparisons, prices, features, and availability.
Stay focused on the store's domain, and avoid unrelated topics (e.g., math, politics).

If the user greets or makes small talk, reply naturally then guide them back to store-related help.

Your main task is to extract structured filters from the user's message to search for products. Filters may include:
- category (e.g., laptop, keyboard, power supply…)
- max_price, min_price
- keywords (from names or descriptions)
- technical_specs (e.g., RAM, GPU, DPI, RGB...)

Return only JSON in this format:
{
category: ...,
max_price: ...,
min_price: ...,
keywords: [...],
technical_specs: { ... }
}

If any fields are missing, set them to null. Do not explain or return anything other than JSON.";

$messages = array_merge([
['role' => 'system', 'content' => $systemPrompt],
], $messages);

$response = Http::withHeaders([
'Authorization' => 'Bearer ' . config('services.openrouter.key'),
'Content-Type' => 'application/json',
])->post('https://openrouter.ai/api/v1/chat/completions', [
'model' => 'openai/gpt-3.5-turbo',
'messages' => $messages,
]);

return json_decode($response['choices'][0]['message']['content'], true);
}

/**
* Generate a human-like response using product list and user query.
*/
protected function generateResponse(string $userMessage, $products): string
{
// Format products list as bullet points
$productList = collect($products)->map(function ($product) {
return "- {$product->name} (\${$product->regular_price}): {$product->short_description}";
})->implode("\n");

$finalPrompt = "The user asked: \"$userMessage\"\n\nHere are the matching products:\n{$productList}\n\nGenerate a helpful and friendly recommendation.";

$response = Http::withHeaders([
'Authorization' => 'Bearer ' . config('services.openrouter.key'),
'Content-Type' => 'application/json',
])->post('https://openrouter.ai/api/v1/chat/completions', [
'model' => 'openai/gpt-3.5-turbo',
'messages' => [
['role' => 'system', 'content' => "You are a friendly AI assistant helping customers find the best electronics in our store."],
['role' => 'user', 'content' => $finalPrompt],
],
]);

return $response['choices'][0]['message']['content'];
}
}
