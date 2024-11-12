<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('user.shoppingcart', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        // Dữ liệu từ form
        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');
        $productQuantity = $request->input('product_quantity', 1);

        // Lấy giỏ hàng hiện tại từ session (nếu không có thì tạo mảng rỗng)
        $cart = Session::get('cart', []);

        // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
        if (isset($cart[$productId])) {
            // Tăng số lượng sản phẩm
            $cart[$productId]['quantity'] += $productQuantity;
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $cart[$productId] = [
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $productQuantity,
            ];
        }

        // Lưu giỏ hàng vào session
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        unset($cart[$id]);
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update(Request $request, $id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity');
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật');
    }
}
