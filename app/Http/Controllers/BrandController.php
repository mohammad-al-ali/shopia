<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Repositories\BrandRepository;
use App\Services\BrandService;
use Exception;
use Illuminate\Support\Facades\View;

/**
 * Class BrandController
 *
 * Handles CRUD operations for managing brands in the admin panel.
 * Uses BrandRepository for data access and BrandService for business logic.
 */
class BrandController extends Controller
{
    /**
     * Repository for accessing brand data.
     *
     * @var BrandRepository
     */
    protected BrandRepository $brandRepository;

    /**
     * Service for handling brand business logic.
     *
     * @var BrandService
     */
    protected BrandService $brandService;

    /**
     * BrandController constructor.
     *
     * @param BrandRepository $brandRepository
     * @param BrandService $brandService
     */
    public function __construct(BrandRepository $brandRepository, BrandService $brandService)
    {
        $this->brandRepository = $brandRepository;
        $this->brandService = $brandService;
    }

    /**
     * Display a paginated list of brands.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function brands()
    {
        $brands = $this->brandRepository->getAllPaginated();
        return view('admin.brand.brands', compact('brands'));
    }

    /**
     * Show the form to create a new brand.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a new brand in the database.
     *
     * @param BrandRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function  store(BrandRequest $request)
    {
        $this->brandService->handleStoreBrand($request);

        return redirect()
            ->route('admin.brand.brands')
            ->with('status', 'Brand has been added successfully!');
    }

    /**
     * Show the form to edit an existing brand.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id): View
    {
        $brand = $this->brandRepository->findById($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update an existing brand in the database.
     *
     * @param BrandRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BrandRequest $request)
    {
        $this->brandService->handleUpdateBrand($request);

        return redirect()
            ->route('admin.brand.brands')
            ->with('status', 'Brand has been updated successfully!');
    }

    /**
     * Delete a brand from the database.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function delete(int $id): \Illuminate\Http\RedirectResponse
    {
        $this->brandService->handleDeleteBrand($id);

        return redirect()
            ->route('admin.brand.brands')
            ->with('status', 'Brand has been deleted successfully!');
    }
}
