<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShopService;

/**
 * Class ShopController
 *
 * Handles displaying the shop page with product filtering, brands,
 * categories, and other related filters.
 */
class ShopController extends Controller
{
    protected ShopService $shopService;

    /**
     * ShopController constructor.
     *
     * @param ShopService $shopService
     */
    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    /**
     * Display the shop page with products, filters, and sorting options.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $this->shopService->getFilteredShopData($request->all());

        return view('shop', [
            'products' => $data['products'],
            'brands' => $data['brands'],
            'categories' => $data['categories'],
            'f_brands' => $request->query('brands'),
            'f_categories' => $request->query('categories'),
            'min_price' => $data['filters']['min_price'],
            'max_price' => $data['filters']['max_price'],
            'size' => $data['size'],
            'order' => $data['orderCode']
        ]);
    }
}
