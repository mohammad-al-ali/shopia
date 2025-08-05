<?php
// app/Services/ShopService.php

namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Repositories\ShopRepository;

class ShopService
{
    protected ShopRepository $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    public function getFilteredShopData(array $request): array
    {
        $size = $request['size'] ?? 12;
        $orderCode = $request['order'] ?? null;

        // حدد عمود الترتيب واتجاهه
        [$column, $direction] = match ($orderCode) {
            1 => ['created_at', 'DESC'],
            2 => ['created_at', 'ASC'],
            3 => ['regular_price', 'DESC'],
            4 => ['regular_price', 'ASC'],
            default => ['id', 'DESC']
        };

        $filters = [
            'brands' => $request['brands'] ?? null,
            'categories' => $request['categories'] ?? null,
            'min_price' => $request['min'] ?? null,
            'max_price' => $request['max'] ?? null,
        ];

        $products = $this->shopRepository->filterProducts($filters, $column, $direction, $size);
        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return compact('products', 'brands', 'categories', 'filters', 'size', 'orderCode');
    }
}
