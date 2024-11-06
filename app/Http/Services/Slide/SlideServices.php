<?php

namespace App\Http\Services\Slide;

use App\Models\Slide;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SlideServices
{
    /**
     * Lấy tất cả các slides
     */
    public function getAllSlides()
    {
        return Slide::orderBy('sort_by', 'asc')->paginate(20);
    }

    /**
     * Tạo slide mới
     */
    public function createSlide($data)
    {
        if (isset($data['thumb'])) {
            $data['thumb'] = $data['thumb']->store('thumbnails', 'public');
        }

        return Slide::create($data);
    }

    /**
     * Cập nhật slide
     */
    public function updateSlide(Slide $slide, $data)
    {
        if (isset($data['thumb'])) {
            // Xóa hình ảnh cũ nếu có
            if ($slide->thumb) {
                Storage::disk('public')->delete($slide->thumb);
            }
            $data['thumb'] = $data['thumb']->store('thumbnails', 'public');
        }

        return $slide->update($data);
    }

    /**
     * Xóa slide
     */
    public function deleteSlide(Slide $slide)
    {
        if ($slide->thumb) {
            Storage::disk('public')->delete($slide->thumb);
        }

        return $slide->delete();
    }
}
