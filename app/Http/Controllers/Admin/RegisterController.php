<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Hiển thị form đăng ký
    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (Auth::check()) {
            return redirect()->route('admin')->with('info', 'Bạn đã đăng nhập.'); // Thông báo người dùng đã đăng nhập
        }

        return view('admin.register', ['title' => 'Đăng ký tài khoản admin']);
    }

    // Xử lý đăng ký
    public function store(Request $request)
    {
        // Định nghĩa thông báo tùy chỉnh
        $messages = [
            'name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ];

        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' đảm bảo khớp với trường 'password_confirmation'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Trả về toàn bộ validator để hiển thị thông báo chi tiết
                ->withInput();
        }

        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);

        // Đăng nhập tự động sau khi đăng ký thành công
        Auth::login($user);

        return redirect()->route('admin')->with('success', 'Đăng ký thành công!');
    }
}
