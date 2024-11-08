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
    // Display the registration form
    public function index()
    {
        // Check if the user is logged in
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();
            
            // Redirect based on the user's role
            if ($user->role == 1) {
                return redirect()->route('admin')->with('info', 'Bạn đã đăng nhập.'); // Redirect to admin page with info message
            }

            // If the role is not 1 (assumed to be a regular user)
            return redirect()->route('user.index')->with('info', 'Bạn đã đăng nhập với vai trò người dùng.'); // Redirect to user page
        }

        // If the user is not logged in, show the registration page
        return view('admin.register', ['title' => 'Đăng ký tài khoản admin']);
    }

    // Handle the registration request
    public function store(Request $request)
    {
        // Custom error messages for validation
        $messages = [
            'name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ];

        // Input validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' ensures it matches 'password_confirmation'
        ], $messages);

        // Redirect back with errors if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create a new user with a default role of 0 (regular user)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'role' => 0, // Default role (change as per your application's logic)
        ]);

        // Automatically log in the user after successful registration
        Auth::login($user);

        // Redirect based on the user's role
        if ($user->role == 1) {
            return redirect()->route('admin')->with('success', 'Đăng ký thành công!');
        }
        return redirect()->route('user')->with('success', 'Đăng ký thành công!');
    }
}
