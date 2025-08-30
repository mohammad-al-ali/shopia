<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Class CategoryService
 *
 * Handles all business logic related to Category management,
 * including creating and updating categories.
 */
class CategoryService
{
    /**
     * Category repository instance.
     *
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Prepare category data from the request.
     *
     * @param Request $request
     * @return array
     */
    private function prepareCategoryData(Request $request): array
    {
        $data = $request->only([
            'name',
            'description',
            'parent_category_id'
        ]);
        $data['updated_at'] = now();
        return $data;
    }

    /**
     * Handle storing a new category.
     *
     * @param Request $request
     * @return void
     */
    public function handleStore(Request $request): void
    {
        $data = $this->prepareCategoryData($request);
        $this->categoryRepository->create($data);
    }

    /**
     * Handle updating an existing category.
     *
     * @param Request $request
     * @return bool
     */
    public function updateCategory(Request $request): bool
    {
        $category = $this->categoryRepository->find($request->id);
        $data = $this->prepareCategoryData($request);
        return $this->categoryRepository->update($category, $data);
    }
}
