<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlideRequest;
use App\Repositories\SlideRepository;
use App\Services\SlideService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class SlideController
 *
 * Handles CRUD operations for Slides in the admin panel.
 */
class SlideController extends Controller
{
    protected SlideRepository $slideRepository;
    protected SlideService $slideService;

    /**
     * SlideController constructor.
     *
     * @param SlideRepository $slideRepository
     * @param SlideService $slideService
     */
    public function __construct(SlideRepository $slideRepository, SlideService $slideService)
    {
        $this->slideRepository = $slideRepository;
        $this->slideService = $slideService;
    }

    /**
     * Display a paginated list of slides.
     *
     * @return \Illuminate\View\View
     */
    public function slides(): View
    {
        $slides = $this->slideRepository->getAllSlidesPaginates();
        return view('admin.slide.slides', compact('slides'));
    }

    /**
     * Show the form to create a new slide.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.slide.create');
    }

    /**
     * Store a newly created slide in storage.
     *
     * @param SlideRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SlideRequest $request): RedirectResponse
    {
        $this->slideService->handelSlideStore($request);
        return redirect()->route('admin.slide.slides')->with('status', 'Create a Slide Successfully');
    }

    /**
     * Show the form for editing the specified slide.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id): View
    {
        $slide = $this->slideRepository->find($id);
        return view('admin.slide.edit', compact('slide'));
    }

    /**
     * Update the specified slide in storage.
     *
     * @param SlideRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SlideRequest $request): RedirectResponse
    {
        $this->slideService->handleSlideUpdate($request);
        return redirect()->route('admin.slide.slides')->with('status', 'Update a Slide Successfully');
    }

    /**
     * Remove the specified slide from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $this->slideService->handleSlideDelete($id);
        return redirect()->route('admin.slide.slides')->with('status', 'Delete a Slide Successfully');
    }
}
