<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Surfsidemedia\Shoppingcart\CartItem;

class Product extends Model

{ public function brand(){
return $this->belongsTo(Brand::class,'brand_id');

}
 public function category(){
    return $this->belongsTo(Category::class,'category_id');

}

    public function orders(){
        return $this->belongsToMany(Order::class,'order_items');

    }
    protected $fillable=[
        'name',
'description',
        'slug',
'short_description',
 'regular_price',
'sale_price',
'warehouse_price',
'quantity',
'image',
        'brand_id',
        'category_id',
        'featured',
        'images',
       'price',
    ];
    public function setNameAttribute($value){
        $this->attributes['name']=$value;
        $this->attributes['slug']=Str::slug($value);
    }


}
