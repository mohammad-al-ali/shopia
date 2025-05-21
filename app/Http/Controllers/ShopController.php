<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
   public function index(Request $request){
       $size=$request->query('size',12);
       $o_column="";
       $o_order="";
       $order=$request->query('order') ;
       $min_price=$request->query('min',1);
       $max_price=$request->query('max',500);

       switch ($order){
           case 1:
               $o_column='created_at';
               $o_order='DESC';
               break;
         case 2:
               $o_column='created_at';
               $o_order='ASC';
               break;
         case 3:
               $o_column='regular_price';
               $o_order='DESC';
               break;
         case 4:
               $o_column='regular_price';
               $o_order='ASC';
               break;
           default:
               $o_column='id';
               $o_order='DESC';
       }
       $brands = Brand::orderBy('name', 'ASC')->get();
       $categories = Category::orderBy('name', 'ASC')->get();

// استقبال القيم المختارة من الطلب
       $f_brands = request()->query('brands');
       $f_categories = request()->query('categories');

// تنفيذ استعلام لتصفية المنتجات
       $products = Product::query();

       if (!empty($f_brands)) {
           $products->whereIn('brand_id', explode(',', $f_brands));
       }

       if (!empty($f_categories)) {
           $products->whereIn('category_id', explode(',', $f_categories));
       }
       if (!empty($min_price) && !empty($max_price)) {
           $products->where(function($query) use ($min_price, $max_price) {
               $query->whereBetween('regular_price', [$min_price, $max_price])
                   ->orWhereBetween('sale_price', [$min_price, $max_price]);
           });
       }
// ترتيب وإضافة التصفية النهائية
       $products = $products->orderBy($o_column, $o_order)->paginate($size);

       return view('shop',compact('products','size','order','brands','f_brands','categories','f_categories','min_price','max_price'));
   }
   public function productDetails($slug){
       $product=Product::where('slug',$slug)->first();
       $rproducts=Product::where('slug','<>',$slug)->get()->take(6);
       return view('details',compact('product','rproducts'));


   }
}
