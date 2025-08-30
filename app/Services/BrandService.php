<?php

namespace App\Services;

use App\Models\Brand;
use App\Repositories\BrandRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits;

/**
 * Class BrandService
 *
 * This service handles all business logic related to Brand management,
 * including creating, updating, and deleting brands.
 * It also processes and manages brand images.
 */
class BrandService
{
    use Traits\ProcessImageTrait;

    /**
     * Brand repository instance.
     *
     * @var BrandRepository
     */
    protected BrandRepository $brandRepository;

    /**
     * Folder name used for storing brand images.
     *
     * @var string
     */
    protected string $brandFolder = 'brands_image';


    /**
     * BrandService constructor.
     *
     * @param BrandRepository $brandRepository
     */
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Prepare brand data from request.
     *
     * @param $request
     * @return array
     */
    private function prepareBrandData( $request): array
    {
        $data = $request->only([
            'name', 'description'
        ]);
        $data['slug'] = Str::slug($request->name);
        return $data;
    }

    /**
     * Handle storing a new brand with image processing.
     *
     * @param $request
     * @return void
     */
    public function handleStoreBrand($request): void
    {
        $data = $this->prepareBrandData($request);
        $data['image'] = $this->processImage($request->file('image'), 124, 124, $this->brandFolder);
        $this->brandRepository->create($data);
    }

    /**
     * Handle updating an existing brand with optional image replacement.
     *
     * @param  $request
     * @return void
     */
    public function handleUpdateBrand($request): void
    {
        $brand = $this->brandRepository->findById($request->id);
        $data = $this->prepareBrandData($request);

        if ($request->image) {
            $data['image'] = $this->replaceImage(
                $brand->image,
                $request->file('image'),
                124,
                124,
                $this->brandFolder
            );
        }

        $this->brandRepository->update($brand, $data);
    }

    /**
     * Handle deleting a brand, including its image, within a transaction.
     *
     * @param int $id
     * @throws Exception
     * @return void
     */
    public function handleDeleteBrand($id): void
    {
        DB::beginTransaction();

        try {
            $brand = Brand::findOrFail($id);

            // Delete main image
            $this->deleteImage($brand->image, $this->brandFolder);

            $this->brandRepository->delete($brand);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
