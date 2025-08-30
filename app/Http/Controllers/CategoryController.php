<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;

/**
 * Class CategoryController
 *
 * Handles CRUD operations for managing categories in the admin panel.
 * Uses CategoryRepository for data access and CategoryService for business logic.
 */
class CategoryController extends Controller
{
    /**
     * Repository for accessing category data.
     *
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * Service for handling category business logic.
     *
     * @var CategoryService
     */
    protected CategoryService $categoryService;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryRepository $categoryRepository, CategoryService $categoryService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a paginated list of categories.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function categories()
    {
        $categories = $this->categoryRepository->getAllPaginated();
        return view('admin.category.Categories', compact('categories'));
    }

    /**
     * Show the form to create a new category.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a new category in the database.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryService->handleStore($request);

        return redirect()
            ->route('admin.category.categories')
            ->with('status', 'Category has been added successfully!');
    }

    /**
     * Show the form to edit an existing category.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update an existing category in the database.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request)
    {
        $this->categoryService->updateCategory($request);

        return redirect()
            ->route('admin.category.categories')
            ->with('status', 'Category has been updated successfully!');
    }

    /**
     * Delete a category from the database.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $this->categoryRepository->delete($id);

        return redirect()
            ->route('admin.category.categories')
            ->with('status', 'Category has been deleted successfully!');
    }
}
