<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function show()
    {
        $address = Address::where('user_id', Auth::id())->first();
        $cartItems = Cart::instance('cart')->content();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة.');
        }

        return view('checkout', compact('address', 'cartItems'));
    }
}
