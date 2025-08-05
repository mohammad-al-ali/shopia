<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\SlideRepository;

class HomeController extends Controller
{ protected SlideRepository $slideRepository;
    protected CategoryRepository $categoryRepository ;
    public function __construct(CategoryRepository $categoryRepository,SlideRepository $slideRepository){
        $this->slideRepository=$slideRepository;
        $this->categoryRepository=$categoryRepository;}
    public function index()
    {
        $slides=$this->slideRepository->getAllSlidesPaginates();
        $categories=$this->categoryRepository->getAllPaginated();
        return view('index',compact('slides','categories'));
    }


}
