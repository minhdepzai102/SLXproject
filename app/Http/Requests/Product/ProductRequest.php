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
            'menu_id' => 'required|integer|exists:menus,id', // Ensure menu_id exists
            'price' => 'required|numeric',
            'price_sale' => 'nullable|numeric',
            'active' => 'required|boolean',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ];
    }

    public function authorize()
    {
        return true; // Allow all requests (customize as needed)
    }
}
