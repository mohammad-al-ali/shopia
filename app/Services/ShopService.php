<?php
// app/Services/ShopService.php

namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Repositories\ShopRepository;

/**
 * Class ShopService
 *
 * Handles retrieving shop data, including filtering products by
 * category, brand, price range, and sorting.
 */
class ShopService
{
    /**
     * Shop repository instance.
     *
     * @var ShopRepository
     */
    protected ShopRepository $shopRepository;

    /**
     * ShopService constructor.
     *
     * @param ShopRepository $shopRepository
     */
    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    /**
     * Retrieve filtered shop data including products, brands, categories, and filters.
     *
     * @param array $request Array containing filter and pagination parameters.
     *                       Possible keys: 'size', 'order', 'brands', 'categories', 'min', 'max'.
     *
     * @return array Returns an array with keys: 'products', 'brands', 'categories', 'filters', 'size', 'orderCode'.
     */
    public function getFilteredShopData(array $request): array
    {
        $size = $request['size'] ?? 12;
        $orderCode = $request['order'] ?? null;

        // Determine sorting column and direction
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
