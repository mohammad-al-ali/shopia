<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
   protected $fillable=[
       'name',
'phone',
'city',
'address',
'locality',
'landmark',
'user_id',
   ];
}
