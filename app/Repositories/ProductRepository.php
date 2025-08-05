<?php
namespace App\Repositories;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class ProductRepository
{
    public function getAllPaginated($perPage = 10)
    {
        return Product::orderBy('id', 'DESC')->paginate($perPage);
    }

    public function getBySlug($slug)
    {
        return Product::where('slug', $slug)->first();
    }

    public function getRelated($slug, $limit = 6)
    {
        return Product::where('slug', '<>', $slug)->take($limit)->get();
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    public function getCategoryList()
    {
        return Category::select('id','name')->orderBy('name')->get();
    }

    public function getBrandList()
    {
        return Brand::select('id','name')->orderBy('name')->get();
    }

    public function delete(Product $product): ?bool
    {
        return $product->delete();

}






}
