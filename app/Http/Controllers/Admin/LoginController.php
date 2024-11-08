<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the login page.
     */
    public function index()
    {
        if (Auth::check()) {
            // Check if the authenticated user is an admin
            if (Auth::user()->role === 1) {
                return redirect()->route('admin'); // Redirect to admin page if user is an admin
            }

            // Redirect to user page if not an admin
            return redirect()->route('user.index')->with('info', 'Bạn đã đăng nhập với vai trò người dùng.');
        }

        return view('admin.login', [
            'title' => 'Đăng Nhập Hệ Thống'
        ]);
    }

    /**
     * Handle the login request.
     */
    public function store(Request $request)
    {
        // Check if the user is already authenticated
        if (Auth::check()) {
            // Redirect based on role
            return $this->redirectUserBasedOnRole();
        }

        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'remember' => 'nullable|boolean', // Optional remember me checkbox
        ], [
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.', // Custom error message for password
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            // Successful authentication, redirect based on role
            return $this->redirectUserBasedOnRole();
        }

        // If authentication fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'Tài khoản hoặc mật khẩu không đúng',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle logout.
     */
    public function logout()
    {
        Auth::logout(); // Log the user out
        return redirect()->route('login')->with('success', 'Đăng xuất thành công.');
    }

    /**
     * Redirects the user based on their role.
     */
    private function redirectUserBasedOnRole()
    {
        if (Auth::user()->role === 1) {
            return redirect()->route('admin'); // Admin route
        }

        return redirect()->route('user.index'); // User route
    }
}
