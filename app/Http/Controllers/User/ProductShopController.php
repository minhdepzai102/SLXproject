<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;

class ProductShopController extends Controller
{
    
    public function index()
    {
        $menu = Menu::where('parent_id', 0)->get();
        $menus = Menu::where('active', 1)->get();
        $parentCategories = Menu::where('parent_id', 0)->get();
        return view('user.shop', compact('menus')); // Pass $menus to the view
    }
}

