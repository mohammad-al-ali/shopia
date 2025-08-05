<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use App\Traits\ApiResponse;

class CategoryApiController extends Controller
{
    use ApiResponse;

    protected CategoryRepository $categoryRepository;
    protected CategoryService $categoryService;

    public function __construct(CategoryRepository $categoryRepository, CategoryService $categoryService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getAllPaginated();
        return $this->apiResponse(CategoryResource::collection($categories), 'ok', 200);
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->handleStore($request);
        return $this->apiResponse(null, 'created successfully', 201);
    }

    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);
        return $this->apiResponse(new CategoryResource($category), 'ok', 200);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryService->UpdateCategory($request, $id);
        return $this->apiResponse(new CategoryResource($category), 'updated successfully', 200);
    }

    public function destroy($id)
    {
        $this->categoryRepository->delete($id);
        return $this->apiResponse(null, 'deleted successfully', 200);
    }
}
