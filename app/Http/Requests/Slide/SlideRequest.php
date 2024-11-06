<?php

namespace App\Http\Requests\Slide;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'url' => 'required|string',
            'active' => 'required|boolean',
            'sort_by' => 'required|integer', // Corrected from 'interger' to 'integer'
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ];
    }

    public function authorize()
    {
        return true; // Allow all requests (customize as needed)
    }
}
