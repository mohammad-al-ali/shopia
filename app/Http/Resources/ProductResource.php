<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->name,
            'description'=>$this->description,
            'short_description'=>$this->short_description,
            'regular_price'=>$this->regular_price,
            'sale_price'=>$this->sale_price,
            'warehouse_price'=>$this->warehouse_price,
            'quantity'=>$this->quantity,
            'image'=>$this->image,
            'brand_id'=>$this->brand_id,
            'category_id'=>$this->category_id,
            'featured'=>$this->featured,
            'images'=>$this->images,
            'price'=>$this->price,
        ];
    }
}
