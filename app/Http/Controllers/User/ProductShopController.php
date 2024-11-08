<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Product;

class ProductShopController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query for active products
        $products = Product::where('active', 1);

        // Apply category filter if any
        if ($request->has('category')) {
            $products = $products->where('menu_id', $request->category);
        }

        // Apply sorting based on selected option
        if ($request->has('sort_by')) {
            switch ($request->sort_by) {
                case 'a_to_z':
                    $products = $products->orderBy('name', 'asc');
                    break;
                case 'z_to_a':
                    $products = $products->orderBy('name', 'desc');
                    break;
                case 'price_low_to_high':
                    $products = $products->orderBy('price', 'asc');
                    break;
                case 'price_high_to_low':
                    $products = $products->orderBy('price', 'desc');
                    break;
                default:
                    break;
            }
        }

        // Fetch products after applying filters and sorting
        $products = $products->get();

        // Fetch all active menus (categories)
        $menus = Menu::where('active', 1)->get();

        return view('user.shop', compact('products', 'menus'));
    }
    public function filterByCategory($category)
    {
        // Get the category (either parent or child)
        $category = Menu::findOrFail($category);

        // Check if it's a parent category
        if ($category->parent_id == 0) {
            // If it's a parent, get all products under its child categories
            $categories = Menu::where('parent_id', $category->id)->pluck('id');
            $products = Product::whereIn('menu_id', $categories)->get();
        } else {
            // If it's a child, get products of this specific category
            $products = Product::where('menu_id', $category->id)->get();
        }

        // Get all menus for the sidebar
        $menus = Menu::where('active', 1)->get();

        return view('user.shop', compact('products', 'menus'));
    }
    public function allProducts()
    {
        // Fetch random 6 active products
        $products = Product::where('active', 1)->inRandomOrder()->take(6)->get(); // Get 6 random products
        $menus = Menu::where('active', 1)->get();
        return view('user.shop', compact('products', 'menus'));
    }
    public function filterByPrice(Request $request)
    {
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Filter products by sale price if available, otherwise fall back to regular price
        $products = Product::when($minPrice && $maxPrice, function ($query) use ($minPrice, $maxPrice) {
            return $query->whereBetween('price_sale', [$minPrice, $maxPrice])
                ->orWhereBetween('price', [$minPrice, $maxPrice]);
        })->get();

        return view('user.shop', compact('products'));
    }
    public function show($id)
    {
        // Lấy sản phẩm theo ID
        $product = Product::findOrFail($id);

        // Trả về view với thông tin sản phẩm
        return view('user.shop-single', compact('product'));
    }
    public function showProductDetail($id)
{
    // Lấy sản phẩm chính dựa trên id
    $product = Product::find($id);

    // Lấy danh sách sản phẩm ngẫu nhiên khác để hiển thị thêm
    $additionalProducts = Product::inRandomOrder()->take(4)->get(); // lấy 4 sản phẩm ngẫu nhiên

    return view('product-detail', compact('product', 'additionalProducts'));
}

}


