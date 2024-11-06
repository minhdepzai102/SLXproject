<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\Menu;
use App\Http\Services\Product\ProductService;

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
    
    public function store(ProductRequest $request)
    {
        $this->productService->create($request->all());

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm');
    }

    public function edit(Product $product)
    {
        return response()->json($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->productService->update($request->all(), $product);

        return redirect()->back()->with('success', 'Sản phẩm đã được cập nhật');
    }

    public function destroy(Product $product)
    {
        $this->productService->destroy($product->id);
        return redirect()->back()->with('success', 'Sản phẩm đã được xóa');
    }
    public function search(Product $request)
{
    $search = $request->input('query');

    $products = Product::where('name', 'LIKE', '%' . $search . '%')
        ->orWhere('description', 'LIKE', '%' . $search . '%')
        ->get();

    return response()->json($products);
}

}
