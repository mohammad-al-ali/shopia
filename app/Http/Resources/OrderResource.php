<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->id,
            'status'=>$this->status,
            'payment_status'=>$this->payment_status,
            'total_amount'=>$this->total_amount,
            'user_id'=>$this->user_id,
            'subtotal'=>$this->subtotal,
            'discount'=>$this->discount,
            'tax'=>$this->tax,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'locality'=>$this->locality,
            'address'=>$this->address,
            'city'=>$this->city,
            'landmark'=>$this->landmark,
            'delivered_date'=>$this->delivered_date,
            'canceled_date'=>$this->canceled_date,
        ];
    }
}
