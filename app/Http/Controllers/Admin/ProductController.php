<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\Menu;
use App\Http\Services\Product\ProductService;
use Illuminate\Http\Request; // Thêm import Request
use App\Models\ProductImage;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAll();
        $menus = Menu::all();

        return view('admin.products.index', [
            'title' => 'Danh Sách Sản Phẩm',
            'products' => $products,
            'menus' => $menus,
        ]);
    }
    public function store(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'price' => 'required|numeric',
            'price_sale' => 'nullable|numeric',
            'menu_id' => 'required|exists:menus,id',
            'thumb' => 'required|array', // Ensure thumb is an array
            'thumb.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Each image in the array should be an image
        ]);

        // Create a new product
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->content = $request->content;
        $product->price = $request->price;
        $product->price_sale = $request->price_sale;
        $product->menu_id = $request->menu_id;
        $product->active = $request->active;

        // Store the images
        $thumbs = [];
        if ($request->hasFile('thumb')) {
            foreach ($request->file('thumb') as $image) {
                $thumbs[] = $image->store('product_thumbs', 'public'); // Store each image and add to the array
            }
        }

        // Save the array of image paths as JSON in the database
        $product->thumb = json_encode($thumbs);
        $product->save();

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm!');
    }


    public function edit(Product $product)
    {
        return response()->json($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        // Cập nhật sản phẩm với các dữ liệu đã xác thực
        $this->productService->update($request->validated(), $product);

        return redirect()->back()->with('success', 'Sản phẩm đã được cập nhật');
    }

    public function destroy(Product $product)
    {
        $this->productService->destroy($product->id);
        return redirect()->back()->with('success', 'Sản phẩm đã được xóa');
    }

    // Cập nhật phương thức search để sử dụng Request thay vì Product
    public function search(Request $request)
    {
        $search = $request->input('query');

        $products = Product::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('description', 'LIKE', '%' . $search . '%')
            ->get();

        return response()->json($products);
    }
}
