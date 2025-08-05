<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShopService;
use App\Http\Resources\ProductResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ShopApiController extends Controller
{
    protected ShopService $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function index(Request $request)
    {
        $data = $this->shopService->getFilteredShopData($request->all());

        return ApiResponse::apiResponse([
            'products' => ProductResource::collection($data['products']),
            'brands' => $data['brands'],
            'categories' => $data['categories'],
            'filters' => $data['filters'],
            'size' => $data['size'],
            'orderCode' => $data['orderCode'],
        ], 'Shop data retrieved successfully.', 200);
    }
}
