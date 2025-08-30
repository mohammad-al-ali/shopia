<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\OrderItem;

class Product extends Model

{
    use HasFactory;
    use SoftDeletes;

    public function brand(){
return $this->belongsTo(Brand::class);

}
 public function category(){
    return $this->belongsTo(Category::class,'category_id');

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
    ];
    public function setNameAttribute($value){
        $this->attributes['name']=$value;
        $this->attributes['slug']=Str::slug($value);
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'order_items')->withPivot('quantity','unit_price');
    }
    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

}
