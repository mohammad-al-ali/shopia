<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
protected $fillable=[
    'id',
'status',
'payment_status',
'total_amount',
'user_id',
'subtotal',
'discount',
'tax',
'name',
'phone',
'locality',
'address',
'city',
'landmark',
'delivered_date',
'canceled_date',
];
    public function user(){
        return $this->belongsTo(User::class);

    }
    public function payment(){
        return $this->hasOne(Payment::class);

    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);

    }
public function products(){
        return $this->belongsToMany(Product::class,'order_items')->withPivot('quantity','unit_price');
}
}
