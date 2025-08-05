<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SlideRequest;
use App\Repositories\SlideRepository;
use App\Services\SlideService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SlideApiController extends Controller
{
    protected SlideRepository $slideRepository;
    protected SlideService $slideService;

    public function __construct(SlideRepository $slideRepository, SlideService $slideService)
    {
        $this->slideRepository = $slideRepository;
        $this->slideService = $slideService;
    }

    // Get all slides (paginated)
    public function index()
    {
        $slides = $this->slideRepository->getAllSlidesPaginates();
        return ApiResponse::apiResponse($slides, 'Slides retrieved successfully.', 200);
    }

    // Store a new slide
    public function store(SlideRequest $request)
    {
        $this->slideService->handelSlideStore($request);
        return ApiResponse::apiResponse([], 'Slide created successfully.', 201);
    }

    // Show a specific slide
    public function show($id)
    {
        $slide = $this->slideRepository->find($id);

        if (!$slide) {
            return ApiResponse::apiResponse([], 'Slide not found.', 404);
        }

        return ApiResponse::apiResponse($slide, 'Slide retrieved successfully.', 200);
    }

    // Update a slide
    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]); // Inject id into request so service can use it
        $this->slideService->handleSlideUpdate($request);
        return ApiResponse::apiResponse([], 'Slide updated successfully.', 200);
    }

    // Delete a slide
    public function destroy($id)
    {
        $this->slideService->handleSlideDelete($id);
        return ApiResponse::apiResponse([], 'Slide deleted successfully.', 200);
    }
}
