<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Http\Services\Product\ProductService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $productService;

    // Constructor for injecting ProductService
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        // Retrieve all menus
        $menus = Menu::all();

        // Get the selected menu ID from the request, if any
        $menuId = $request->get('menu_id');

        // Retrieve products based on the selected menu
        if ($menuId) {
            $products = $this->productService->getByMenuId($menuId);
        } else {
            $products = $this->productService->getAll(); // Default to all products if no menu is selected
        }

        // Pass menus and products data to the view
        return view('user.index', compact('menus', 'products'));
    }
}
