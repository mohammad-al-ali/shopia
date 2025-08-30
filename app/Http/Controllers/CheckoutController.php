<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

/**
 * Class CheckoutController
 *
 * Handles the checkout process, including retrieving the user's address
 * and validating that the cart is not empty before proceeding.
 */
class CheckoutController extends Controller
{
    /**
     * Display the checkout page if the cart has items.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function show()
    {
        // Get the authenticated user's address (if available)
        $address = Address::where('user_id', Auth::id())->first();

        // Retrieve items from the shopping cart
        $cartItems = Cart::instance('cart')->content();

        // Redirect if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Show checkout page with address and cart items
        return view('checkout', compact('address', 'cartItems'));
    }
}
