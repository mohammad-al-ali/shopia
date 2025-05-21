<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Brand extends Model
{
//   public static function boot()
//   {
//       parent::boot();
//       static::creating(function ($brand){
//           $brand->slug=Str::slug($brand->name);
//       });
//   }

    public function products(){
        return $this->hasMany(Product::class);

    }
    protected $fillable=[
        'name',
        'slug',
        'image',
        'description'
    ];
    public function setNameAttribute($value){
        $this->attributes['name']=$value;
        $this->attributes['slug']=Str::slug($value);
    }
}
