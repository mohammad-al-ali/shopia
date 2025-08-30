<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Traits\ProcessImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class ProductService
 *
 * Handles all operations related to products, including creating,
 * updating, deleting, and managing product image and galleries.
 */
class ProductService
{
    use ProcessImageTrait;

    /**
     * Product repository instance.
     *
     * @var ProductRepository
     */
    protected ProductRepository $productRepository;

    /**
     * Folder path to store product images.
     *
     * @var string
     */
    protected string $productFolder = 'products_image';

    /**
     * ProductService constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Prepare product data from the request.
     *
     * @param Request $request
     * @return array
     */
    private function prepareProductData(Request $request): array
    {
        $data = $request->only([
            'name', 'description', 'short_description', 'regular_price',
            'sale_price', 'warehouse_price', 'featured', 'quantity',
            'brand_id', 'category_id'
        ]);
        $data['slug'] = Str::slug($request->name);
        return $data;
    }

    /**
     * Handle product gallery images.
     *
     * @param $files
     * @return string|null
     */
    private function handleGallery( $files): ?string
    {
        if (!$files) return null;

        $galleryArray = [];
        $count = 1;
        foreach ($files as $file) {
            $fileName = $this->processImage($file, 540, 689, $this->productFolder . '/gallery', $count);
            $galleryArray[] = $fileName;
            $count++;
        }
        return implode(',', $galleryArray);
    }

    /**
     * Delete gallery images.
     *
     * @param string|null $gallery
     * @param string $folderName
     * @return void
     */
    private function deleteGallery($gallery, $folderName): void
    {
        if (!$gallery) return;

        foreach (explode(',', $gallery) as $image) {
            $this->deleteImage($image, $folderName . '/gallery');
        }
    }

    /**
     * Handle storing a new product.
     *
     * @param Request $request
     * @return void
     */
    public function handleStoreProduct(Request $request): void
    {
        $data = $this->prepareProductData($request);
        $data['image'] = $this->processImage($request->file('image'), 540, 689, $this->productFolder);
        $data['images'] = $this->handleGallery($request->file('images'));
        $this->productRepository->create($data);
    }

    /**
     * Handle updating an existing product.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function handleUpdateProduct(Request $request, $id): void
    {
        $data = $this->prepareProductData($request);
        $product = $this->productRepository->find($id);

        if ($request->image) {
            $data['image'] = $this->replaceImage($product->image, $request->file('image'), 540, 689, $this->productFolder);
        }

        if ($request->file('images')) {
            $data['images'] = $this->handleGallery($request->file('images'));
            $this->deleteGallery($product->images, $this->productFolder);
        }

        $this->productRepository->update($product, $data);
    }

    /**
     * Handle deleting a product and its images.
     * Uses transaction; falls back to soft delete on failure.
     *
     * @param int $id
     * @return void
     */
    public function handleDeleteProduct(int $id): void
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepository->find($id);

            $this->deleteImage($product->image, $this->productFolder);
            $this->deleteGallery($product->images, $this->productFolder);

            $product->forceDelete();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            // Fallback to soft delete
            if (isset($product)) {
                $this->productRepository->update($product, ['deleted_at' => now()]);
            }

            // Optional: log the error for later debugging
            // Log::error($e->getMessage());
        }
    }
}
