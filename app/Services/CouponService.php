<?php
namespace App\Services;

use App\Repositories\CouponRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CouponService
{
    protected CouponRepository $couponRepository;


    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function applyCoupon(string $code): bool
    {
        $cartSubtotal = Cart::instance('cart')->subtotal(); // احصل على المجموع كعدد عشري

        $coupon = $this->couponRepository->findValidByCode($code, $cartSubtotal);

        if (!$coupon) {
            return false;
        }

        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value,
        ]);

        $this->calculateDiscount();

        return true;
    }

    public function removeCoupon(): void
    {
        Session::forget('coupon');
        Session::forget('discounts');
    }

    public function calculateDiscount(): void
    {
        if (!Session::has('coupon')) {
            Session::forget('discounts');
            return;
        }

        $coupon = Session::get('coupon');

        $discount = 0;

        if ($coupon['type'] === 'fixed') {
            $discount = $coupon['value'];
        } else { // نسبة مئوية
            $discount = (Cart::instance('cart')->subtotal() * $coupon['value']) / 100;
        }

        $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
        $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

        Session::put('discounts', [
            'discount' => number_format($discount, 2, '.', ''),
            'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
            'tax' => number_format($taxAfterDiscount, 2, '.', ''),
            'total' => number_format($totalAfterDiscount, 2, '.', ''),
        ]);
    }
}
