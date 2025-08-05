<?php
namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class OrderRepository
{
    public function getAllPaginated($limit = 12)
    {
        return Order::orderBy('created_at', 'DESC')->paginate($limit);
    }

    public function find($id)
    {
        return Order::find($id);
    }

    public function findItems($order_id, $limit = 12)
    {
        return OrderItem::where('order_id', $order_id)->orderBy('id')->paginate($limit);
    }

    public function getPayment($order_id)
    {
        return Payment::where('order_id', $order_id)->first();
    }

    public function createOrder(array $data)
    {
        return Order::create($data);
    }

    public function createOrderItem(array $data)
    {
        return OrderItem::create($data);
    }

    public function createPayment(array $data)
    {
        return Payment::create($data);
    }

    public function updateStatus(Order $order, string $status): bool
    {
        $order->status = $status;
        return $order->save();
    }

    public function save(Order $order): bool
    {
        return $order->save();
    }

    public function userOrder($limit=10){
        return Order::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate($limit);
    }
}
