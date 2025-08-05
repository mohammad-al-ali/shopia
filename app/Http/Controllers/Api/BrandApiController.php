<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;  // ننصح باستخدام FormRequest مخصص للتحقق
use App\Http\Resources\BrandResource;
use App\Repositories\BrandRepository;
use App\Services\BrandService;
use App\Traits\ApiResponse;
use Exception;

// حسب تعريفك


class BrandApiController extends Controller
{
protected BrandRepository $brandRepository;
protected BrandService $brandService;

public function __construct(BrandRepository $brandRepository, BrandService $brandService)
{
$this->brandRepository = $brandRepository;
$this->brandService = $brandService;
}

public function index()
{
$brands = $this->brandRepository->getAllPaginated();
return ApiResponse::apiResponse(BrandResource::collection($brands), 'ok', 200);
}

public function store(BrandRequest $request)
{
$this->brandService->handleStoreBrand($request);
return ApiResponse::apiResponse(null, 'created', 201);
}

public function update(BrandRequest $request, $id)
{
$this->brandService->handleUpdateBrand($request, $id);
return ApiResponse::apiResponse(null, 'updated', 200);
}

    /**
     * @throws Exception
     */
    public function destroy($id)
{
$this->brandService->handleDeleteBrand($id);
return ApiResponse::apiResponse(null, 'deleted', 200);
}
}
