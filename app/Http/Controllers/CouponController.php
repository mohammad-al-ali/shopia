<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Repositories\CouponRepository;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected CouponRepository $couponRepository;
    protected CouponService $couponService;

    public function __construct(CouponRepository $couponRepository, CouponService $couponService)
    {
        $this->couponRepository = $couponRepository;
        $this->couponService = $couponService;
    }

    public function coupons()
    {
        $coupons = $this->couponRepository->getAllPaginated(12);
        return view('admin.coupon.coupons', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(CouponRequest $request)
    {
        $this->couponRepository->create($request->validated());
        return redirect()->route('admin.coupon.coupons')->with('status', 'تمت إضافة الكوبون!');
    }

    public function edit($id)
    {
        $coupon = $this->couponRepository->find($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    public function update(CouponRequest $request)
    {
        $coupon = $this->couponRepository->find($request->id);
        $this->couponRepository->update($coupon, $request->validated());

        return redirect()->route('admin.coupon.coupons')->with('status', 'تم تعديل الكوبون!');
    }

    public function destroy($id)
    {
        $coupon = $this->couponRepository->find($id);
        $this->couponRepository->delete($coupon);

        return redirect()->route('admin.coupon.coupons')->with('status', 'تم حذف الكوبون!');
    }

    public function apply(Request $request)
    {
        $code = $request->input('coupon_code');

        if ($this->couponService->applyCoupon($code)) {
            return redirect()->back()->with('success', 'تم تطبيق الكوبون!');
        } else {
            return redirect()->back()->with('error', 'كود الكوبون غير صحيح أو منتهي الصلاحية!');
        }
    }

    public function remove()
    {
        $this->couponService->removeCoupon();
        return redirect()->back()->with('success', 'تم إزالة الكوبون!');
    }
}
