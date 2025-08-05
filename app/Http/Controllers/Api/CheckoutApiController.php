<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;


class CheckoutApiController extends Controller
{
    public function show()
    {
        // Retrieve cart contents for the "cart" instance
        $cartItems = Cart::instance('cart')->content();

        // If the cart is empty, return error response
        if ($cartItems->isEmpty()) {
            return ApiResponse::apiResponse([], 'Cart is empty.', 400);
        }

        // Get the authenticated user's first address
        $address = Address::where('user_id', Auth::id())->first();

        // Return JSON response with cart and address
        return ApiResponse::apiResponse([
            'address' => $address,
            'cart_items' => $cartItems,
        ], 'Checkout data loaded successfully.', 200);
    }
}
