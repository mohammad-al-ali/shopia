<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Services\CartService;

/**
 * Class CartController
 *
 * Handles shopping cart operations:
 * - Viewing cart items
 * - Adding items to the cart
 * - Updating item quantity
 * - Deleting single items
 * - Clearing the entire cart
 */
class CartController extends Controller
{
    /**
     * Service for handling cart operations.
     *
     * @var CartService
     */
    protected CartService $cartService;

    /**
     * CartController constructor.
     *
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display all cart items.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $items = $this->cartService->getCartItems();
        return view('cart', compact('items'));
    }

    /**
     * Add an item to the cart.
     *
     * @param CartRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(CartRequest $request)
    {
        $this->cartService->addToCart($request);
        return redirect()->back()->with('status', 'Item has been added to cart successfully!');
    }

    /**
     * Change the quantity of a specific cart item.
     *
     * @param string $rowId
     * @param string $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeQuantity($rowId, $action)
    {
        try {
            $this->cartService->updateQuantity($rowId, $action);
            return redirect()->back()->with('status', 'Quantity has been updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove an item from the cart.
     *
     * @param string $rowId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($rowId)
    {
        $this->cartService->delete($rowId);
        return redirect()->back()->with('status', 'Item has been removed from cart successfully!');
    }

    /**
     * Clear the entire cart.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        $this->cartService->destroy();
        return redirect()->back()->with('status', 'Cart has been cleared successfully!');
    }
}
