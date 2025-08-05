<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    protected $orderService;
    protected $orderRepository;

    public function __construct(OrderService $orderService,OrderRepository $orderRepository)
    {
        $this->orderService = $orderService;
        $this->orderRepository=$orderRepository;
    }

    public function orders()
    {
        $orders = $this->orderRepository->getAllPaginated();
        return view('admin.order.orders', compact('orders'));
    }

    public function show($order_id)
    {
        $details = $this->orderService->getOrderDetails($order_id);
        return view('admin.order.show', [
            'order' => $details['order'],
            'orderItems' => $details['items'],
            'payment' => $details['payment'],
        ]);
    }

    public function updateStatus(Request $request)
    {
        $this->orderService->updateOrderStatus($request->order_id, $request->order_status);
        return back()->with('status', 'Status changed successfully!');
    }

    public function cancel($id)
    {
        $this->orderService->updateOrderStatus($id, 'canceled');
        return back()->with('status', 'Cancel successfully!');
    }

    public function create(OrderRequest $request)
    {

        $this->orderService->createOrderFromCheckout($request);
        return redirect()->route('order-confirmation');
    }

    public function confirmation()
    {
        if (Session::has('order_id')) {
            $order = $this->orderService->getOrderDetails(Session::get('order_id'))['order'];
            $mode = Session::get('mode');
            return view('order-confirmation', compact('order', 'mode'));
        } else {
            return view('cart.index');
        }
    }
}
