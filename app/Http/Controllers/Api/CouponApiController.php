<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Resources\CouponResource;
use App\Repositories\CouponRepository;
use App\Services\CouponService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CouponApiController extends Controller
{
    protected CouponRepository $couponRepository;
    protected CouponService $couponService;

    public function __construct(CouponRepository $couponRepository, CouponService $couponService)
    {
        $this->couponRepository = $couponRepository;
        $this->couponService = $couponService;
    }

    // List all coupons (paginated)
    public function index()
    {
        $coupons = $this->couponRepository->getAllPaginated(10);
        return ApiResponse::apiResponse(CouponResource::collection($coupons), 'Coupons retrieved successfully.', 200);
    }

    // Store a new coupon
    public function store(CouponRequest $request)
    {
        $coupon = $this->couponRepository->create($request->validated());
        return ApiResponse::apiResponse(new CouponResource($coupon), 'Coupon created successfully.', 201);
    }

    // Update an existing coupon
    public function update(CouponRequest $request, $id)
    {
        $coupon = $this->couponRepository->find($id);
        $this->couponRepository->update($coupon, $request->validated());

        return ApiResponse::apiResponse(new CouponResource($coupon), 'Coupon updated successfully.', 200);
    }

    // Delete a coupon
    public function destroy($id)
    {
        $coupon = $this->couponRepository->find($id);
        $this->couponRepository->delete($coupon);

        return ApiResponse::apiResponse([], 'Coupon deleted successfully.', 200);
    }

    // Apply a coupon code
    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => ['required', 'string'],
        ]);

        if ($this->couponService->applyCoupon($request->coupon_code)) {
            return ApiResponse::apiResponse([], 'Coupon applied successfully.', 200);
        }

        return ApiResponse::apiResponse([], 'Invalid or expired coupon.', 400);
    }

    // Remove the applied coupon
    public function remove()
    {
        $this->couponService->removeCoupon();
        return ApiResponse::apiResponse([], 'Coupon removed successfully.', 200);
    }
}
