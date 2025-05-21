<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
   public function index(){
       $items=Cart::instance('cart')->content();
return view('cart',compact('items'));
   }
   public function addToCart(Request $request){
       $items=Cart::instance('cart')->content();
Cart::instance('cart')->add($request->id,$request->name,$request->quantity,$request->price)->associate(Product::class);
return redirect()->back();
   }
   public function increase($rowId){
       $product=Cart::instance('cart')->get($rowId);
   $qty=$product->qty +1;
       Cart::instance('cart')->update($rowId,$qty);
       return redirect()->back();

   }
    public function decrease($rowId){

        $product=Cart::instance('cart')->get($rowId);
        $qty=$product->qty - 1;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect()->back();
    }
    public function delete($rowId){
       Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }
    public function clear(){
       Cart::instance('cart')->destroy();
        return redirect()->back();
    }




    public function applyCoupon(Request $request){
        $coupon_code = $request->coupon_code;
        if (isset($coupon_code)){
            $coupon=Coupon::where('code',$coupon_code)->where('expiry_date','>=',Carbon::today())
            ->where('cart_value','<=',Cart::instance('cart')->subtotal)->first();
            if (!$coupon){
                return redirect()->back()->with('error','Invalid Coupon Code!');
            }
            else{
                Session::put('coupon',[
                    'code'=>$coupon->code,
                    'type'=>$coupon->type,
                    'value'=>$coupon->value,
                    'cart_value'=>$coupon->cart_value,
                ]);
                $this->calculateDiscount();
                return redirect()->back()->with('success','Coupon has been applied!');
            }

        }
        else{
            return redirect()->back()->with('error','Invalid Coupon Code!');
        }
    }
    public function calculateDiscount()
    {
        $discount = 0;
        if(Session::has('coupon'))
        {
            if(Session::get('coupon')['type']=='fixed')
            {
                $discount = Session::get('coupon')['value'];
            }
            else{
                $discount = (Cart::instance('cart')->subtotal() * Session::get('coupon')['value'])/100;
            }
        }

        $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
        $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax'))/100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

        Session::put('discounts',[
            'discount' => number_format(floatval($discount),2,'.',''),
            'subtotal' => number_format(floatval($subtotalAfterDiscount),2,'.',''),
            'tax' => number_format(floatval($taxAfterDiscount),2,'.',''),
            'total' => number_format(floatval($totalAfterDiscount),2,'.','')
        ]);
    }
    public function removeCoupon(Request $request){
       Session::forget('coupon');
       Session::forget('discounts');
        return redirect()->back()->with('success','Coupon has been removed!');
    }
    public function checkout(){
       if (!Auth::check()){
           return redirect()->route('login');
       }
       $user=Auth::user();
       return view('checkout',compact('user'));
    }
}
