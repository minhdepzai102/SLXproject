<?php

namespace App\Http\Services\Product;
use Illuminate\Support\Facades\Storage;


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
    // Tạo mới sản phẩm với nhiều ảnh
    public function create(array $data)
    {
        $validatedData = $this->validateProduct($data);

        try {
            // Xử lý tải ảnh và lưu đường dẫn vào mảng
            if (isset($data['thumb']) && is_array($data['thumb'])) {
                $imagePaths = $this->handleThumbUpload($data['thumb']);
                $validatedData['thumb'] = $imagePaths; // Lưu ảnh vào mảng thumb

                // Tạo sản phẩm mới
                $product = Product::create($validatedData);

                // Lưu ảnh vào bảng product_images
                foreach ($imagePaths as $path) {
                    $product->images()->create(['image_path' => $path]);
                }
            }

            Session::flash('success', 'Tạo sản phẩm thành công');
        } catch (\Exception $err) {
            Log::error('Product Create Error:', ['error' => $err->getMessage()]);
            Session::flash('error', 'Có lỗi xảy ra khi tạo sản phẩm.');
            return false;
        }

        return true;
    }


    // Update an existing product
    public function update(array $data, Product $product)
    {
        

        // Xác thực dữ liệu
        $validatedData = $this->validateProduct($data);

        // Xử lý tải ảnh thumbnail (nếu có)
        if (isset($data['thumb']) && is_array($data['thumb'])) {
            // Xử lý việc upload các ảnh mới
            $validatedData['thumb'] = $this->handleThumbUpload($data['thumb']);
        }

        // Xử lý xóa ảnh thumbnail đã bị xóa (nếu có)
        if (isset($data['removed_thumbnails']) && is_array($data['removed_thumbnails'])) {
            $removedThumbnails = $data['removed_thumbnails'];

            // Lấy các thumbnail hiện tại từ database
            $currentThumbnails = json_decode($product->thumb, true);

            // Xóa các ảnh đã bị xóa khỏi thư mục lưu trữ
            foreach ($removedThumbnails as $thumb) {
                // Kiểm tra và xóa ảnh trong thư mục nếu tồn tại
                if (Storage::exists('public/' . $thumb)) {
                    Storage::delete('public/' . $thumb);
                }

                // Xóa ảnh khỏi danh sách thumbnail trong database
                $currentThumbnails = array_filter($currentThumbnails, function ($item) use ($thumb) {
                    return $item !== $thumb;
                });
            }

            // Cập nhật lại thông tin các thumbnail sau khi xóa
            $validatedData['thumb'] = json_encode(array_values($currentThumbnails));
        }

        // Cập nhật sản phẩm
        $product->update($validatedData);

        // Hiển thị thông báo thành công
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
            'quantity' => 'required|integer|min:0',
            'size' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
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
    // Xử lý tải lên nhiều ảnh
    private function handleThumbUpload($thumbs)
    {
        $paths = [];
        if ($thumbs && is_array($thumbs)) {
            foreach ($thumbs as $thumb) {
                // Kiểm tra và lưu từng ảnh
                if ($thumb->isValid()) {
                    $paths[] = $thumb->store('thumbnails', 'public'); // Lưu vào thư mục thumbnails
                }
            }
        }
        return $paths; // Trả về mảng các đường dẫn
    }

}
