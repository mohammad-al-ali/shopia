<?php

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Support\Collection;
use Surfsidemedia\Shoppingcart\Facades\Cart;

/**
 * Class CartService
 *
 * This service handles all operations related to the shopping cart,
 * including adding items, updating quantities, deleting items,
 * and clearing the cart.
 */
class CartService
{
    /**
     * Get all items currently in the cart.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCartItems(): Collection
    {
        return Cart::instance('cart')->content();
    }

    /**
     * Add a product to the cart.
     *
     * @param array $data
     * @return void
     */
    public function addToCart(array $data): void
    {
        Cart::instance('cart')->add(
            $data['id'],
            $data['name'],
            $data['quantity'],
            $data['price']
        )->associate(Product::class);
    }

    /**
     * Update the quantity of a cart item.
     *
     * @param string $rowId
     * @param string $action 'increase' or 'decrease'
     * @throws Exception
     * @return void
     */
    public function updateQuantity(string $rowId, string $action): void
    {
        $item = Cart::instance('cart')->get($rowId);

        if (!$item) {
            throw new Exception('Item not found in the cart');
        }

        $qty = $item->qty;

        if ($action === 'increase') {
            $qty += 1;
        } elseif ($action === 'decrease') {
            if ($qty <= 1) {
                throw new Exception('Quantity cannot be less than 1');
            }
            $qty -= 1;
        } else {
            throw new \InvalidArgumentException('Invalid action type');
        }

        Cart::instance('cart')->update($rowId, $qty);
    }

    /**
     * Remove a specific item from the cart.
     *
     * @param int $rowId
     * @return void
     */
    public function delete(int $rowId): void
    {
        Cart::instance('cart')->remove($rowId);
    }

    /**
     * Clear all items from the cart.
     *
     * @return void
     */
    public function destroy(): void
    {
        Cart::instance('cart')->destroy();
    }
}
