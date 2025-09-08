<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
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
    protected ProductRepository $productRepository;

    /**
     * HomeController constructor.
     *
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @param SlideRepository $slideRepository
     */
    public function __construct(ProductRepository $productRepository,CategoryRepository $categoryRepository, SlideRepository $slideRepository)
    {
        $this->slideRepository = $slideRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository=$productRepository;
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
        $products=$this->productRepository->getFeature();

        return view('index', compact('slides', 'categories','products'));
    }
}
