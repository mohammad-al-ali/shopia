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

    public function searchByFilters(array $filters)
    {
        $query = Product::query();

        // 🔍 الفئة (Category)
        if (!empty($filters['category'])) {
            $category = strtolower($filters['category']);
            $query->whereHas('category', function ($q) use ($category) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$category}%"]);
            });
        }

        // 💰 السعر (نراعي كل من regular_price و sale_price)
        if (!empty($filters['min_price'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('regular_price', '>=', $filters['min_price'])
                    ->orWhere('sale_price', '>=', $filters['min_price']);
            });
        }

        if (!empty($filters['max_price'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('regular_price', '<=', $filters['max_price'])
                    ->orWhere('sale_price', '<=', $filters['max_price']);
            });
        }

        // 🔑 الكلمات المفتاحية (name + description + short_description)
        if (!empty($filters['keywords']) && is_array($filters['keywords'])) {
            foreach ($filters['keywords'] as $keyword) {
                $keyword = strtolower($keyword);
                $query->where(function ($q) use ($keyword) {
                    $q->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
                        ->orWhereRaw('LOWER(description) LIKE ?', ["%{$keyword}%"])
                        ->orWhereRaw('LOWER(short_description) LIKE ?', ["%{$keyword}%"]);
                });
            }
        }

        // ⚙️ المواصفات التقنية (نفترض أنها موجودة في الوصف أو الوصف المختصر)
        if (!empty($filters['technical_specs']) && is_array($filters['technical_specs'])) {
            foreach ($filters['technical_specs'] as $key => $value) {
                $value = strtolower($value);
                $query->where(function ($q) use ($value) {
                    $q->whereRaw('LOWER(description) LIKE ?', ["%{$value}%"])
                        ->orWhereRaw('LOWER(short_description) LIKE ?', ["%{$value}%"]);
                });
            }
        }

        // 🧪 النتيجة النهائية (عرض الحقول الأساسية فقط)
        return $query->take(5)->get([
            'id',
            'name',
            'regular_price',
            'sale_price',
            'short_description',
            'image'
        ]);
    }




}
