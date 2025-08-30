<?php
namespace App\Repositories;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

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

    public function delete(Product $product)
    {
        return $product->delete();

}


// Inside your EloquentProductRepository class

    /**
     * Searches for products based on a flexible set of filters.
     * This improved version enhances performance, price logic, and search relevance.
     *
     * @param array $filters An associative array of filters.
     * @return Collection
     */
    public function searchByFilters(array $filters)
    {
        $query = Product::query();

        // 🔍 Category Filter
        // Note: Assuming your database collation is case-insensitive (e.g., utf8mb4_unicode_ci)
        // which is a best practice and avoids performance issues with LOWER().
        if (!empty($filters['category'])) {
            $category = $filters['category'];
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', 'LIKE', "%{$category}%");
            });
        }

        // 💰 Price Filter (Improved Logic)
        // This logic now correctly checks the effective price (sale_price if available, otherwise regular_price).
        if (!empty($filters['min_price'])) {
            $minPrice = $filters['min_price'];
            $query->where(function ($q) use ($minPrice) {
                // The product is valid if:
                // 1. It has a sale_price which is >= minPrice
                // OR
                // 2. It has NO sale_price AND its regular_price is >= minPrice
                $q->where('sale_price', '>=', $minPrice)
                    ->orWhere(function ($subQ) use ($minPrice) {
                        $subQ->whereNull('sale_price')
                            ->where('regular_price', '>=', $minPrice);
                    });
            });
        }

        if (!empty($filters['max_price'])) {
            $maxPrice = $filters['max_price'];
            $query->where(function ($q) use ($maxPrice) {
                // The product is valid if:
                // 1. It has a sale_price which is <= maxPrice
                // OR
                // 2. It has NO sale_price AND its regular_price is <= maxPrice
                $q->where('sale_price', '<=', $maxPrice)
                    ->orWhere(function ($subQ) use ($maxPrice) {
                        $subQ->whereNull('sale_price')
                            ->where('regular_price', '<=', $maxPrice);
                    });
            });
        }

        // 🔑 Keywords & ⚙️ Technical Specs (Combined & Improved Logic)
        // We combine keywords and specs into a single search pool.
        // This now performs an OR search, which is more user-friendly.
        $searchTerms = array_merge(
            isset($filters['keywords']) ? $filters['keywords'] : [],
            isset($filters['technical_specs']) ? array_values($filters['technical_specs']) : []
        );

        if (!empty($searchTerms)) {
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    if (!empty($term)) {
                        // This creates a chain of "OR WHERE name LIKE ... OR WHERE description LIKE ..."
                        // for all search terms, finding products that match ANY of them.
                        $q->orWhere('name', 'LIKE', "%{$term}%")
                            ->orWhere('description', 'LIKE', "%{$term}%")
                            ->orWhere('short_description', 'LIKE', "%{$term}%");
                    }
                }
            });
        }

        // 🧪 Final Result (Selecting essential fields)
        return $query->select([
            'id',
            'name',
            'slug',
            'regular_price',
            'sale_price',
            'quantity', // It's useful to get quantity for availability status
            'short_description',
        ])
            ->take(5)
            ->get();
    }






}
