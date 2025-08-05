<?php
namespace App\Repositories;
use App\Models\Product;

class ShopRepository
{
    public function filterProducts(array $filters, string $orderColumn = 'id', string $orderDirection = 'DESC', int $size = 12)
    {
        $query = Product::query();

        // ✅ 1. فلترة الماركات
        if (!empty($filters['brands'])) {
            $brands = is_array($filters['brands']) ? $filters['brands'] : explode(',', $filters['brands']);
            $query->whereIn('brand_id', $brands);
        }

        // ✅ 2. فلترة التصنيفات
        if (!empty($filters['categories'])) {
            $categories = is_array($filters['categories']) ? $filters['categories'] : explode(',', $filters['categories']);
            $query->whereIn('category_id', $categories);
        }

        // ✅ 3. فلترة بالسعر (سعر عادي أو مخفّض)
        if (!empty($filters['min_price']) && !empty($filters['max_price'])) {
            $min = floatval($filters['min_price']);
            $max = floatval($filters['max_price']);

            $query->where(function($q) use ($min, $max) {
                $q->whereBetween('regular_price', [$min, $max])
                    ->orWhereBetween('sale_price', [$min, $max]);
            });
        }

        // ✅ 4. ترتيب النتائج
        $allowedColumns = ['id', 'created_at', 'regular_price'];
        $allowedDirections = ['ASC', 'DESC'];

        // حماية ضد ترتيب غير مسموح به
        if (!in_array($orderColumn, $allowedColumns)) {
            $orderColumn = 'id';
        }

        if (!in_array(strtoupper($orderDirection), $allowedDirections)) {
            $orderDirection = 'DESC';
        }

        return $query->orderBy($orderColumn, $orderDirection)
            ->paginate($size);
    }
}
