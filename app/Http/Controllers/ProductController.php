<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Traits\ProcessImageTrait;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

/**
 * Class ProductController
 *
 * Handles CRUD operations for products in admin panel
 * and shows product details on the frontend.
 */
class ProductController extends Controller
{
    use ProcessImageTrait;

    protected ProductRepository $productRepository;
    protected ProductService $productService;

    /**
     * ProductController constructor.
     */
    public function __construct(ProductRepository $productRepository, ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    /**
     * Display paginated list of products (admin side).
     */
    public function products()
    {
        $products = $this->productRepository->getAllPaginated();

        return view('admin.product.products', compact('products'));
    }

    /**
     * Show a single product detail page (frontend).
     */
    public function show(string $slug)
    {
        $product = $this->productRepository->getBySlug($slug);
        $related_products = $this->productRepository->getRelated($slug);

        return view('details', compact('product', 'related_products'));
    }

    /**
     * Show create product form (admin side).
     */
    public function create()
    {
        $categories = $this->productRepository->getCategoryList();
        $brands = $this->productRepository->getBrandList();

        return view('admin.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created product.
     */
    public function store(ProductRequest $request)
    {
        $this->productService->handleStoreProduct($request);

        return redirect()
            ->route('admin.product.products')
            ->with('status', 'Product added successfully');
    }

    /**
     * Show edit form for a product.
     */
    public function edit(int $id)
    {
        $product = $this->productRepository->find($id);
        $categories = $this->productRepository->getCategoryList();
        $brands = $this->productRepository->getBrandList();

        return view('admin.product.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update an existing product.
     */
    public function update(ProductRequest $request, int $id)
    {
        $this->productService->handleUpdateProduct($request, $id);

        return redirect()
            ->route('admin.product.products')
            ->with('status', 'Product updated successfully');
    }

    /**
     * Delete a product by ID.
     */
    public function delete(int $id)
    {
        $this->productService->handleDeleteProduct($id);

        return redirect()
            ->route('admin.product.products')
            ->with('status', 'Product deleted successfully');
    }
}
