<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Facades\PayPal;

/**
 * Class OrderController
 *
 * Handles order management for both admin and user checkout flow.
 */
class OrderController extends Controller
{
    protected OrderService $orderService;
    protected OrderRepository $orderRepository;

    /**
     * OrderController constructor.
     *
     * @param OrderService $orderService
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderService $orderService, OrderRepository $orderRepository)
    {
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display paginated list of all orders (admin side).
     *
     * @return \Illuminate\View\View
     */
    public function orders()
    {
        $orders = $this->orderRepository->getAllPaginated();
        return view('admin.order.orders', compact('orders'));
    }

    /**
     * Show details for a specific order.
     *
     * @param int $order_id
     * @return \Illuminate\View\View
     */
    public function show(int $order_id)
    {
        $details = $this->orderService->getOrderDetails($order_id);

        return view('admin.order.show', [
            'order' => $details['order'],
            'orderItems' => $details['items'],
            'payment' => $details['payment'],
        ]);
    }

    /**
     * Update order status.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request)
    {
        $this->orderService->updateOrderStatus($request->order_id, $request->order_status);

        return back()->with('status', 'Status changed successfully!');
    }

    /**
     * Cancel an order by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(int $id)
    {
        $this->orderService->updateOrderStatus($id, 'canceled');

        return back()->with('status', 'Cancel successfully!');
    }

    /**
     * Create a new order from checkout.
     *
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(OrderRequest $request)
    {
        $order = $this->orderService->createOrderFromCheckout($request);

        // إذا كانت طريقة الدفع PayPal
        if ($request->mode === 'paypal') {
            $provider = PayPal::setProvider();
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $checkoutData = [
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $order->total_amount
                        ]
                    ]
                ],
                "application_context" => [
                    "cancel_url" => route('paypal.cancel'),
                    "return_url" => route('paypal.success'),
                ]
            ];

            $response = $provider->createOrder($checkoutData);

            if (isset($response['id']) && $response['status'] === 'CREATED') {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return redirect()->route('cart.checkout')->with('error', 'Something went wrong with PayPal.');
        }

        // أي طرق دفع أخرى
        return redirect()->route('order-confirmation');
    }

    public function paypalSuccess(Request $request)
    {
        $provider = PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {

            $orderId = Session::get('order_id');
 Order::find($orderId)->update(['payment_status' => 'completed']);

            return redirect()->route('order-confirmation')->with('success', 'Payment successful!');
        }

        return redirect()->route('cart.checkout')->with('error', 'Payment failed or cancelled.');
    }

    public function paypalCancel()
    {
        return redirect()->route('cart.checkout')->with('error', 'You cancelled the PayPal payment.');

    }

    /**
     * Show order confirmation page.
     *
     * @return \Illuminate\View\View
     */
    public function confirmation()
    {
        if (Session::has('order_id')) {
            $order = $this->orderService->getOrderDetails(Session::get('order_id'))['order'];
            $mode = Session::get('mode');

            return view('order-confirmation', compact('order', 'mode'));
        }
        return view('cart.index');
    }
}
