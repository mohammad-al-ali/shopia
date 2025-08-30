<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\SlideRepository;

/**
 * Class HomeController
 *
 * Handles the home page display including slides and categories.
 */
class HomeController extends Controller
{
    protected SlideRepository $slideRepository;
    protected CategoryRepository $categoryRepository;

    /**
     * HomeController constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param SlideRepository $slideRepository
     */
    public function __construct(CategoryRepository $categoryRepository, SlideRepository $slideRepository)
    {
        $this->slideRepository = $slideRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the home page with slides and categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $slides = $this->slideRepository->getAllSlidesPaginates();
        $categories = $this->categoryRepository->getAllPaginated();

        return view('index', compact('slides', 'categories'));
    }
}
