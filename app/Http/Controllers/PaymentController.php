<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payment=Payment::all();
        return view('payment.index',compact('payment'));
    }
    public function create()
    {
        return view('payment.create');
    }
    public function store(Request $request)
    {

//        $request->validate([
//            'name'=>'required'|'string'|'max:255',
//            'description'=>'nullable'|'string'|'max:1000',
//            ]);

        Payment::create([
            'order_id'=>$request->order_id,
            'payment_method'=>$request->payment_method,
            'transaction_id'=>$request->transaction_id,
            'amount'=>$request->amount,
            'updated_at'=>now()
        ]);
        return to_route('payment.index');

    }
    public function show( $id)
    {
        $payment=Payment::findOrFail($id);
        return view('payment.show',compact('payment'));

    }
    public function edit( $id)
    {
        $payment=Payment::findOrFail($id);
        return view('payment.show',compact('payment'));
    }
    public function update(Request $request, $id)
    {
// $request->validate([
//        'name'=>'required'|'string'|'max:255',
//        'description'=>'nullable'|'string'|'max:1000',
//    ]);
        Payment::findOrFail($id)->update([

            'order_id'=>$request->order_id,
            'payment_method'=>$request->payment_method,
            'transaction_id'=>$request->transaction_id,
            'amount'=>$request->amount,
            'updated_at'=>now()



        ]);
        return to_route('payment.index');
    }
    public function delete( $id)
    {
        Payment::destroy($id);
        return to_route('payment.index');
    }
}
