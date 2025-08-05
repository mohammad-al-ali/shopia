<?php
namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use Exception;
use App\Traits\ProcessImageTrait;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

class ProductController extends Controller
{use ProcessImageTrait;
    protected ProductRepository $productRepository;
    protected ProductService $productService;
    public function __construct(ProductRepository $productRepository,ProductService $productService){
        $this->productRepository=$productRepository;
        $this->productService=$productService;
    }
    public function products(){
        $products=$this->productRepository->getAllPaginated();

        return view('admin.product.products',compact('products'));}
    public function show($slug){
        $product=$this->productRepository->getBySlug($slug);
        $related_products=$this->productRepository->getRelated($slug);
        return view('details',compact('product','related_products'));}
    public function create(){
        $categories=$this->productRepository->getCategoryList();
        $brands=$this->productRepository->getBrandList();
        return view('admin.product.create',compact('categories','brands'));}
    public function store(ProductRequest $request)
    {
$this->productService->handleStoreProduct($request);

// ✅ 4. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.product.products')->with('status', 'تمت إضافة المنتج بنجاح!');
    }
    public function edit($id){
        $product=$this->productRepository->find($id);
        $categories=$this->productRepository->getCategoryList();
        $brands=$this->productRepository->getBrandList();
        return view('admin.product.edit',compact('product','categories','brands'));
    }
    public function update(ProductRequest $request,$id)
    {
        $this->productService->handleUpdateProduct($request,$id);
        return redirect()->route('admin.product.products')->with('status', 'تمت تعديل المنتج بنجاح!');
    }
    public function delete($id){
        $this->productService->handleDeleteProduct($id);
        return redirect()->route('admin.product.products')->with('status', 'تم حذف المنتج بنجاح!');
    }
}
