<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use App\Traits\ApiResponse;

class UserApiController extends Controller
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    // عرض الطلبات الخاصة بالمستخدم المسجل
    public function orders()
    {
        $orders = $this->orderRepository->userOrder(10);
        return ApiResponse::apiResponse(OrderResource::collection($orders), 'User orders retrieved successfully.', 200);
    }
}
