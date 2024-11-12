<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra nếu người dùng chưa đăng nhập hoặc không phải là admin
        if (!$request->user() || $request->user()->role != '1') {
            // Nếu không phải admin, chuyển hướng đến trang khác (ví dụ trang home)
            return redirect()->route('user.index');

        }

        // Nếu là admin, trả về view chính
        return view('admin.main', ['title' => 'Main Page']);
    }
}
