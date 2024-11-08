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
        'thumb' => 'nullable|array', // Chấp nhận một mảng ảnh
        'thumb.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra tất cả các ảnh trong mảng
    ];
}
    public function authorize()
    {
        return true; // Allow all requests (customize as needed)
    }
}
