<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ProductApiController extends Controller
{
    protected ProductRepository $productRepository;
    protected ProductService $productService;
    public function __construct(ProductRepository $productRepository,ProductService $productService){
        $this->productRepository=$productRepository;
        $this->productService=$productService;
    }
    public function index()
    {
        $products=$this->productRepository->getAllPaginated();
        return ApiResponse::apiResponse(ProductResource::collection($products),'ok',200);

    }
    public function getDependenciesForProductCreating(){
        $categories=$this->productRepository->getCategoryList();
        $brands=$this->productRepository->getBrandList();
        if ($brands->isEmpty() || $categories->isEmpty()) {
            return ApiResponse::apiResponse(null, 'There is no data to complete the process.', 404);
        }
$data=[
    'brands'=>BrandResource::collection($brands),
    'categories'=>CategoryResource::collection($categories)
];
    return ApiResponse::apiResponse($data,'ok',200);
    }
    public function store(ProductRequest $request)
    {
        $this->productService->handleStoreProduct($request);
        return ApiResponse::apiResponse(null, 'Product created successfully', 201);

    }
    public function getDependenciesForProductEdit($id){
        $product=$this->productRepository->find($id);
        if (!$product) {
            return ApiResponse::apiResponse(null, 'Product not found', 404);
        }
        $categories=$this->productRepository->getCategoryList();
        $brands=$this->productRepository->getBrandList();
        $data=[
            'brands'=>BrandResource::collection($brands),
            'categories'=>CategoryResource::collection($categories),
            'product'=> new ProductResource($product),
        ];
        return ApiResponse::apiResponse($data, 'Product loaded for editing', 200);
    }
    public function show($slug)
    {
        $product=$this->productRepository->getBySlug($slug);
        if (!$product) {
            return ApiResponse::apiResponse(null, 'Product not found', 404);
        }
        $relatedProducts=$this->productRepository->getRelated($slug);
        $data=[
            'product'=> new ProductResource($product),
            'relatedProducts'=>ProductResource::collection($relatedProducts),
        ];
        return ApiResponse::apiResponse($data,'ok',200);

    }
    public function update(ProductRequest $request, string $id)
    {

        $this->productService->handleUpdateProduct($request,$id);
        return ApiResponse::apiResponse(null, 'Product updated successfully', 200);

    }
    public function destroy($id)
    {
        $this->productService->handleDeleteProduct($id);

return ApiResponse::apiResponse(null,'"Product deleted successfully"',204);

    }
}
