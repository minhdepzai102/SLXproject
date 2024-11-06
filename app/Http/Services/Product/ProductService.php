<?php

namespace App\Http\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Support\Facades\Validator; // Import Validator facade
use Illuminate\Validation\ValidationException; // Import ValidationException

class ProductService
{
    // Get all products with pagination
    public function getAll()
    {
        return Product::orderByDesc('id')->paginate(20);
    }

    // Create a new product
    public function create(array $data)
    {
        // Validate the data
        $validatedData = $this->validateProduct($data);

        try {
            // Handle thumbnail upload if it exists
            $validatedData['thumb'] = $this->handleThumbUpload($data['thumb'] ?? null);

            Product::create($validatedData);

            Session::flash('success', 'Tạo sản phẩm thành công');
        } catch (\Exception $err) {
            Log::error('Product Create Error:', ['error' => $err->getMessage()]); // Log the error
            Session::flash('error', 'Có lỗi xảy ra khi tạo sản phẩm.'); // Generic error message
            return false;
        }

        return true;
    }

    // Update an existing product
    public function update(array $data, Product $product)
    {
        // Validate the data
        $validatedData = $this->validateProduct($data);

        // Handle thumbnail upload if a new one is provided
        if (isset($data['thumb'])) {
            $validatedData['thumb'] = $this->handleThumbUpload($data['thumb']);
        }

        // Update the product
        $product->update($validatedData);

        Session::flash('success', 'Cập nhật sản phẩm thành công!');
        return true;
    }

    // Delete a product by ID
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            Session::flash('success', 'Sản phẩm đã được xóa thành công!');
            return true;
        }

        Session::flash('error', 'Sản phẩm không tìm thấy.');
        return false; // Return false if the product was not found
    }

    // Validate product data
    private function validateProduct(array $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'menu_id' => 'required|integer|exists:menus,id', // Ensure menu_id exists
            'price' => 'required|numeric',
            'price_sale' => 'nullable|numeric',
            'active' => 'required|boolean',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated(); // Return the validated data
    }

    // Handle thumbnail upload
    private function handleThumbUpload($thumb)
    {
        if ($thumb) {
            return $thumb->store('thumbnails', 'public'); // Save in the public storage
        }
        return null; // Return null if no thumbnail is provided
    }
}
