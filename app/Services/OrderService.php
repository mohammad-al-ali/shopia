<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Address;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class OrderService
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrderDetails($order_id)
    {
        return [
            'order' => $this->orderRepository->find($order_id),
            'items' => $this->orderRepository->findItems($order_id),
            'payment' => $this->orderRepository->getPayment($order_id),
        ];
    }

    public function updateOrderStatus($order_id, $status)
    {
        $order = $this->orderRepository->find($order_id);

        $order->status = $status;
        if ($status === 'delivered') {
            $order->delivered_date = now();
            $order->payment_status = 'completed';
        } elseif ($status === 'canceled') {
            $order->canceled_date = now();
            $order->payment_status = 'refunded';
        }

        $this->orderRepository->save($order);
    }

    public function createOrderFromCheckout($request)
    {
        $user_id = Auth::id();
        $address = Address::where('user_id', $user_id)->first();
        if ($address){
            $address->update([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'city'=>$request->city,
                'address'=>$request->address,
                'locality'=>$request->locality,
                'landmark'=>$request->landmark,
                'updated_at'=>now(),
            ]);
        }
        else
            $address=Address::create([$request]);
        $this->setCheckoutSession();

        $order = $this->orderRepository->createOrder([
            'user_id' => $user_id,
            'total_amount' => Session::get('checkout')['total'],
            'subtotal' => Session::get('checkout')['subtotal'],
            'discount' => Session::get('checkout')['discount'],
            'tax' => Session::get('checkout')['tax'],
            'name' => $address->name,
            'phone' => $address->phone,
            'locality' => $address->locality,
            'address' => $address->address,
            'city' => $address->city,
            'landmark' => $address->landmark,
        ]);

        foreach (Cart::instance('cart')->content() as $item) {
            $this->orderRepository->createOrderItem([
                'quantity' => $item->qty,
                'unit_price' => $item->price,
                'order_id' => $order->id,
                'product_id' => $item->id,
            ]);
        }

        $this->orderRepository->createPayment([
            'order_id' => $order->id,
            'user_id' => $user_id,
            'payment_method' => $request->mode,
            'transaction_id' => $request->transaction_id,
            'amount' => Session::get('checkout')['total'],
        ]);

        Cart::instance('cart')->destroy();
        Session::forget(['discounts', 'checkout', 'coupon']);
        Session::put('order_id', $order->id);
        Session::put('mode', $request->mode);

        return $order;
    }

    public function setCheckoutSession()
    {
        if (Cart::instance('cart')->content()->count() > 0) {
            if (Session::has('coupon')) {
                Session::put('checkout', Session::get('discounts'));
            } else {
                Session::put('checkout', [
                    'discount' => 0,
                    'subtotal' => Cart::instance('cart')->subtotal(),
                    'tax' => Cart::instance('cart')->tax(),
                    'total' => Cart::instance('cart')->total(),
                ]);
            }
        } else {
            Session::forget('checkout');
        }
    }
}
