<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    protected OrderService $orderService;
    protected OrderRepository $orderRepository;

    public function __construct(OrderService $orderService, OrderRepository $orderRepository)
    {
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
    }

    // List all orders with pagination
    public function index()
    {
        $orders = $this->orderRepository->getAllPaginated();
        return ApiResponse::apiResponse(OrderResource::collection($orders), 'Orders retrieved successfully.', 200);
    }

    // Show details of a specific order by ID
    public function show($order_id)
    {
        $details = $this->orderService->getOrderDetails($order_id);

        if (!$details || !$details['order']) {
            return ApiResponse::apiResponse([], 'Order not found.', 404);
        }

        // Return detailed order information with related items and payment info
        return ApiResponse::apiResponse([
            'order' => new OrderResource($details['order']),
            'orderItems' => $details['items'], // يمكن تعديلها Resource لاحقاً حسب الحاجة
            'payment' => $details['payment'],
        ], 'Order details retrieved successfully.', 200);
    }

    // Update the status of an order
    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'order_status' => 'required|string',
        ]);

        $this->orderService->updateOrderStatus($request->order_id, $request->order_status);

        return ApiResponse::apiResponse([], 'Order status updated successfully.', 200);
    }

    // Cancel a specific order by ID
    public function cancel($id)
    {
        $this->orderService->updateOrderStatus($id, 'canceled');
        return ApiResponse::apiResponse([], 'Order canceled successfully.', 200);
    }

    // Create a new order from checkout data
    public function store(OrderRequest $request)
    {
        $order = $this->orderService->createOrderFromCheckout($request);

        return ApiResponse::apiResponse($order, 'Order created successfully.', 201);
    }

    // Show order confirmation based on session order_id
    public function confirmation(Request $request)
    {
        $order_id = $request->session()->get('order_id');
        $mode = $request->session()->get('mode');

        if (!$order_id) {
            return ApiResponse::apiResponse([], 'No order found in session.', 404);
        }

        $details = $this->orderService->getOrderDetails($order_id);
        if (!$details || !$details['order']) {
            return ApiResponse::apiResponse([], 'Order details not found.', 404);
        }

        return ApiResponse::apiResponse([
            'order' => new OrderResource($details['order']),
            'mode' => $mode,
        ], 'Order confirmation retrieved successfully.', 200);
    }
}
