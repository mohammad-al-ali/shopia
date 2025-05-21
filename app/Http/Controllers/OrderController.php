<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $order=Order::all();
        return view('order.index',compact('order'));
    }
    public function create()
    {
        return view('order.create');
    }
    public function store(Request $request)
    {

//        $request->validate([
//            'name'=>'required'|'string'|'max:255',
//            'description'=>'nullable'|'string'|'max:1000',
//            ]);

        Order::create([
            'status'=>$request->status,
            'payment_status'=>$request->payment_status,
            'total_amount'=>$request->total_amount,
            'user_id'=>$request->user_id,
            'updated_at'=>now()

        ]);
        return to_route('order.index');

    }
    public function show( $id)
    {
        $order=Order::findOrFail($id);
        return view('order.show',compact('order'));

    }
    public function edit( $id)
    {
        $order=Order::findOrFail($id);
        return view('order.show',compact('order'));
    }
    public function update(Request $request, $id)
    {
// $request->validate([
//        'name'=>'required'|'string'|'max:255',
//        'description'=>'nullable'|'string'|'max:1000',
//    ]);
        Order::findOrFail($id)->update([
            'status'=>$request->status,
            'payment_status'=>$request->payment_status,
            'total_amount'=>$request->total_amount,
            'user_id'=>$request->user_id,
            'updated_at'=>now()

        ]);
        return to_route('order.index');
    }
    public function delete( $id)
    {
        Order::destroy($id);
        return to_route('order.index');
    }
}
