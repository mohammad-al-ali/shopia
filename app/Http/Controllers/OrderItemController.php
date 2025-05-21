<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $order_item=OrderItem::all();
        return view('order_item.index',compact('order_item'));
    }
    public function create()
    {
        return view('order_item.create');
    }
    public function store(Request $request)
    {

//        $request->validate([
//            'name'=>'required'|'string'|'max:255',
//            'description'=>'nullable'|'string'|'max:1000',
//            ]);

        OrderItem::create([
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'product_id'=>$request->product_id,
            'order_id'=>$request->order_id,
            'updated_at'=>$request->updated_at,
        ]);
        return to_route('order_item.index');

    }
    public function show( $id)
    {
        $order_item=OrderItem::findOrFail($id);
        return view('order_item.show',compact('order_item'));

    }
    public function edit( $id)
    {
        $order_item=OrderItem::findOrFail($id);
        return view('order_item.show',compact('order_item'));
    }
    public function update(Request $request, $id)
    {
// $request->validate([
//        'name'=>'required'|'string'|'max:255',
//        'description'=>'nullable'|'string'|'max:1000',
//    ]);
        OrderItem::findOrFail($id)->update([
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'product_id'=>$request->product_id,
            'order_id'=>$request->order_id,
            'updated_at'=>$request->updated_at,

        ]);
        return to_route('order_item.index');
    }
    public function delete( $id)
    {
        OrderItem::destroy($id);
        return to_route('order_item.index');
    }
}
