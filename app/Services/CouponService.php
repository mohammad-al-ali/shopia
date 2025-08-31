<?php
namespace App\Services;

use App\Repositories\CouponRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

/**
 * Class CouponService
 *
 * Handles coupon application, removal, and discount calculations.
 */
class CouponService
{
    /**
     * Coupon repository instance.
     *
     * @var CouponRepository
     */
    protected CouponRepository $couponRepository;

    /**
     * CouponService constructor.
     *
     * @param CouponRepository $couponRepository
     */
    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * Apply a coupon code to the current cart.
     *
     * @param string $code
     * @return bool Returns true if coupon is valid and applied, false otherwise.
     */
    public function applyCoupon(string $code): bool
    {
        $cartSubtotal = Cart::instance('cart')->subtotal();

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

    /**
     * Remove an applied coupon from the session.
     *
     * @return void
     */
    public function removeCoupon(): void
    {
        Session::forget('coupon');
        Session::forget('discounts');
    }

    /**
     * Calculate discount, tax, and total after applying coupon.
     *
     * @return void
     */
    public function calculateDiscount(): void
    {
        if (!Session::has('coupon')) {
            Session::forget('discounts');
            return;
        }

        $coupon = Session::get('coupon');

        // ✅ تحويل subtotal إلى float
        $cartSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));

        $discount = 0;

        if ($coupon['type'] === 'fixed') {
            $discount = $coupon['value'];
        } else {
            $discount = ($cartSubtotal * $coupon['value']) / 100;
        }

        $subtotalAfterDiscount = $cartSubtotal - $discount;
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
