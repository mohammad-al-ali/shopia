<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slide;
use App\Traits\ApiResponse;


class HomeApiController extends Controller
{
    // Return homepage data (slides + categories)
    public function index()
    {
        // Get active slides (limited to 3)
        $slides = Slide::where('status', 1)->take(3)->get();

        // Get all categories ordered by name
        $categories = Category::orderBy('name')->get();

        // Return the combined response
        return ApiResponse::apiResponse([
            'slides' => $slides,
            'categories' => $categories,
        ], 'Homepage data retrieved successfully.', 200);
    }
}
