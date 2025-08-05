<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository){
        $this->orderRepository=$orderRepository;

    }
    public function index()
    {$users=User::all();
        return view('user.index',compact('users'));
    }
    public function orders(){
        $orders=$this->orderRepository->userOrder(10); return view('user.account.orders',compact('orders'));
    }
    public function create()
    {
        return view('user.create');
    }
    public function store(Request $request)
    {

//        $request->validate([
//            'name'=>'required'|'string'|'max:255',
//            'description'=>'nullable'|'string'|'max:1000',
//            ]);

        User::create([
            'name'=>$request->name,
            'description'=>$request->description,
        ]);
        return to_route('user.index');

    }
    public function show( $id)
    {
        $user=User::findOrFail($id);
        return view('user.show',compact('user'));

    }
    public function edit( $id)
    {
        $user=User::findOrFail($id);
        return view('edit.show',compact('user'));
    }
    public function update(Request $request, $id)
    {
// $request->validate([
//        'name'=>'required'|'string'|'max:255',
//        'description'=>'nullable'|'string'|'max:1000',
//    ]);
        User::findOrFail($id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
             'password'=>$request->password,
             'phone'=>$request->phone,
             'address'=>$request->address,


        ]);
        return to_route('user.index');
    }
    public function delete( $id)
    {
        User::destroy($id);
        return to_route('user.index');
    }



}
