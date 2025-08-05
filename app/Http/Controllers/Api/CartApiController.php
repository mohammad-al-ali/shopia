<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Services\CartService;
use App\Traits\ApiResponse;


class CartApiController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // عرض عناصر السلة
    public function index()
    {
        $items = $this->cartService->getCartItems();
        return ApiResponse::apiResponse($items, 'Cart items retrieved successfully', 200);
    }

    // إضافة عنصر إلى السلة
    public function add(CartRequest $request)
    {
        $this->cartService->addToCart($request);
        return ApiResponse::apiResponse(null, 'Item added to cart', 201);
    }

    // تغيير الكمية
    public function changeQuantity($rowId, $action)
    {
        try {
            $this->cartService->updateQuantity($rowId, $action);
            return ApiResponse::apiResponse(null, 'Quantity updated successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::apiResponse(null, $e->getMessage(), 400);
        }
    }

    // حذف عنصر من السلة
    public function delete($rowId)
    {
        $this->cartService->delete($rowId);
        return ApiResponse::apiResponse(null, 'Item removed from cart', 200);
    }

    // تفريغ السلة بالكامل
    public function clear()
    {
        $this->cartService->destroy();
        return ApiResponse::apiResponse(null, 'Cart cleared successfully', 200);
    }
}
