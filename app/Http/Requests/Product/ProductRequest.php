<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'menu_id' => 'required|integer|exists:menus,id',
            'price' => 'required|numeric',
            'price_sale' => 'nullable|numeric',
            'active' => 'required|boolean',
            'size' => 'nullable|string|max:255', // Validates size is a string and max length of 255 characters
            'brand' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',  // Add this line for quantity validation
            'thumb' => 'nullable|array', // Accept an array of images
            'thumb.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each image in the array
        ];
    }

    public function authorize()
    {
        return true; // Allow all requests (customize as needed)
    }
}
