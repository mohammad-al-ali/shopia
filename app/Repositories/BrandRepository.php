<?php
namespace App\Repositories;

use App\Models\Brand;

class BrandRepository{
    public function getAllPaginated($perPage=10){
        return Brand::orderBy('id','DESC')->paginate($perPage);
    }
    public function create($data): void
    {
Brand::create($data);
    }
    public function findById($id){
        return Brand::find($id);
    }
    public function update(Brand $brand,array $date): bool
    {
        return $brand->update($date);
    }
    public function delete(Brand $brand): void
    {
        $brand->delete();
    }



}
