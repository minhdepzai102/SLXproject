<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slide\SlideRequest;
use App\Models\Slide;
use App\Http\Services\Slide\SlideServices;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    protected $slideService;

    public function __construct(SlideServices $slideService)
    {
        $this->slideService = $slideService;
    }

    public function index()
    {
        $slides = $this->slideService->getAllSlides();
        return view('admin.slide.index', compact('slides'))->with('title', 'Quản lý Slide');
    }

    public function store(SlideRequest $request)
    {
        $this->slideService->createSlide($request->validated());
        return redirect()->route('slide.index')->with('success', 'Slide added successfully');
    }

    public function update(SlideRequest $request, Slide $slide)
    {
        $this->slideService->updateSlide($slide, $request->validated());
        return redirect()->route('slide.index')->with('success', 'Slide updated successfully');
    }

    public function destroy(Slide $slide)
    {
        $this->slideService->deleteSlide($slide);
        return redirect()->route('slide.index')->with('success', 'Slide deleted successfully');
    }
}
