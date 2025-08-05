<?php
namespace App\Services;

use App\Models\Product;
use Exception;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartService
{
    public function getCartItems()
    {
        return Cart::instance('cart')->content();
    }
    public function addToCart($data): void
    {

        Cart::instance('cart')->add(
            $data['id'],
            $data['name'],
            $data['quantity'],
            $data['price']
        )->associate(Product::class);
    }

    /**
     * @throws Exception
     */
    public function updateQuantity(string $rowId, string $action): void
    {
        $item = Cart::instance('cart')->get($rowId);

        if (!$item) {
            throw new Exception('العنصر غير موجود في السلة');
        }

        $qty = $item->qty;

        if ($action === 'increase') {
            $qty += 1;
        } elseif ($action === 'decrease') {
            if ($qty <= 1) {
                throw new Exception('لا يمكن تقليل الكمية أقل من 1');
            }
            $qty -= 1;
        } else {
            throw new \InvalidArgumentException('نوع العملية غير صالح');
        }

        Cart::instance('cart')->update($rowId, $qty);
    }
    public function delete($rowId): void
    {
        Cart::instance('cart')->remove($rowId);
    }
    public function destroy(): void
    {
        Cart::instance('cart')->destroy();
    }
}
