<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlideRequest;
use App\Repositories\SlideRepository;
use App\Services\SlideService;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    protected SlideRepository $slideRepository;
protected SlideService $slideService;
    public function __construct(SlideRepository $slideRepository,SlideService $slideService){
        $this->slideRepository=$slideRepository;
        $this->slideService=$slideService;
    }
    public function slides(){
        $slides=$this->slideRepository->getAllSlidesPaginates();
        return view('admin.slide.slides',compact('slides'));
    }
    public function create(){
        return view('admin.slide.create');
    }
    public function store(SlideRequest $request){
      $this->slideService->handelSlideStore($request);
        return redirect()->route('admin.slide.slides')->with('status','Create a Slide Successfully');
    }
    public function edit($id){
        $slide=$this->slideRepository->find($id);
        return view('admin.slide.edit',compact('slide'));

    }
    public function update(Request $request){
        $this->slideService->handleSlideUpdate($request);
        return redirect()->route('admin.slide.slides')->with('status','Update a Slide Successfully');
    }
    public function delete($id){
       $this->slideService->handleSlideDelete($id);
        return redirect()->route('admin.slide.slides')->with('status','Delete a Slide Successfully');

    }

}
