<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;

use App\Services\CartService;
class CartController extends Controller
{    protected CartService $cartService;
    public function __construct(CartService $cartService){
        $this->cartService=$cartService;
    }

   public function index(){
       $items=$this->cartService->getCartItems();
return view('cart',compact('items'));
   }
   public function add(CartRequest $request){
$this->cartService->addToCart($request);
return redirect()->back();
   }
    public function changeQuantity($rowId, $action)
    {
        try {
            $this->cartService->updateQuantity($rowId, $action);
            return redirect()->back()->with('status', 'تم تحديث الكمية بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function delete($rowId){

        $this->cartService->delete($rowId);
        return redirect()->back();
    }
    public function clear(){
        $this->cartService->destroy();
        return redirect()->back();
    }
}
