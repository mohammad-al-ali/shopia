<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Brand extends Model
{   use SoftDeletes;

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
