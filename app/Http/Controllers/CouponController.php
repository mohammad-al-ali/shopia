<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Repositories\CouponRepository;
use App\Services\CouponService;
use Illuminate\Http\Request;

/**
 * Class CouponController
 *
 * Handles CRUD operations for coupons in the admin panel
 * and coupon application/removal in the checkout process.
 */
class CouponController extends Controller
{
    protected CouponRepository $couponRepository;
    protected CouponService $couponService;

    /**
     * CouponController constructor.
     *
     * @param CouponRepository $couponRepository
     * @param CouponService $couponService
     */
    public function __construct(CouponRepository $couponRepository, CouponService $couponService)
    {
        $this->couponRepository = $couponRepository;
        $this->couponService = $couponService;
    }

    /**
     * Display a paginated list of coupons.
     */
    public function coupons()
    {
        $coupons = $this->couponRepository->getAllPaginated(12);
        return view('admin.coupon.coupons', compact('coupons'));
    }

    /**
     * Show the form to create a new coupon.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created coupon in the database.
     *
     * @param CouponRequest $request
     */
    public function store(CouponRequest $request)
    {
        $this->couponRepository->create($request->validated());
        return redirect()->route('admin.coupon.coupons')->with('status', 'Coupon created successfully!');
    }

    /**
     * Show the form to edit an existing coupon.
     *
     * @param int $id
     */
    public function edit($id)
    {
        $coupon = $this->couponRepository->find($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified coupon in the database.
     *
     * @param CouponRequest $request
     */
    public function update(CouponRequest $request)
    {
        $coupon = $this->couponRepository->find($request->id);
        $this->couponRepository->update($coupon, $request->validated());

        return redirect()->route('admin.coupon.coupons')->with('status', 'Coupon updated successfully!');
    }

    /**
     * Remove the specified coupon from the database.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $coupon = $this->couponRepository->find($id);
        $this->couponRepository->delete($coupon);

        return redirect()->route('admin.coupon.coupons')->with('status', 'Coupon deleted successfully!');
    }

    /**
     * Apply a coupon code to the current cart/session.
     *
     * @param Request $request
     */
    public function apply(Request $request)
    {
        $code = $request->input('coupon_code');

        if ($this->couponService->applyCoupon($code)) {
            return redirect()->back()->with('success', 'Coupon applied successfully!');
        } else {
            return redirect()->back()->with('error', 'Invalid or expired coupon code!');
        }
    }

    /**
     * Remove the currently applied coupon from the session/cart.
     */
    public function remove()
    {
        $this->couponService->removeCoupon();
        return redirect()->back()->with('success', 'Coupon removed successfully!');
    }
}
