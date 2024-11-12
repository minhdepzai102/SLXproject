<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\Menu;
use App\Http\Services\Product\ProductService;
use Illuminate\Http\Request; // Thêm import Request
use App\Models\Rating;
use App\Models\ProductImage;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    // Controller Method to get the view
    public function index()
    {
        $products = $this->productService->getAll();
        $parentMenus = Menu::where('parent_id', 0)->get();  // Get parent menus (parent_id = 0)
        

        return view('admin.products.index', [
            'title' => 'Danh Sách Sản Phẩm',
            'products' => $products,
            'parentMenus' => $parentMenus,  // Pass the parent menus to the view
        ]);
    }

    // AJAX Method to get child menus
    public function getChildMenus(Request $request)
    {
        $childMenus = Menu::where('parent_id', $request->parent_id)->get(); // Fetch child menus based on parent_id
        return response()->json($childMenus);  // Return as JSON response
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
            'child_menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:0',
            'size' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
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
        $product->menu_id = $request->child_menu_id;
        $product->active = $request->active;
        $product->quantity = $request->quantity;
        $product->size = $request->size;
        $product->brand = $request->brand;

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
    public function rateProduct(Request $request, $productId)
    {
        // Validate the rating input    

        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        // Find the product
        $product = Product::findOrFail($productId);

        // Check if the user has already rated this product
        $rating = Rating::where('product_id', $product->id)
            ->where('user_id', auth()->id()) // Assuming user is authenticated
            ->first();

        // If the user has already rated, update the rating
        if ($rating) {
            $rating->rating = $request->rating;
        } else {
            // If the user hasn't rated yet, create a new rating
            $rating = new Rating();
            $rating->product_id = $product->id;
            $rating->user_id = auth()->id();
            $rating->rating = $request->rating;
        }

        // Save the rating
        $rating->save();

        // Calculate new average rating
        $averageRating = $product->ratings->avg('rating');
        $product->average_rating = $averageRating;
        $product->save();

        // Return the new rating and number of comments
        return response()->json([
            'success' => true,
            'new_rating' => number_format($averageRating, 1),
            'comment_count' => $product->ratings->count()
        ]);
    }
    public function liveSearch(Request $request)
    {
        $query = $request->input('q');
        $products = Product::where('name', 'like', "%{$query}%")->get();

        foreach ($products as $product) {
            // Decode the thumb field (JSON string) to get the first image
            $thumbs = json_decode($product->thumb, true); // Decode to array

            // Check if thumbs are available and construct the correct URL
            $product->product_image = !empty($thumbs) ? asset('public/storage/' . $thumbs[0]) : null;
        }

        return response()->json($products);
    }

}
