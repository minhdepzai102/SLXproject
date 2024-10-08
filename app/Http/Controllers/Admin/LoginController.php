<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\c;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('admin'); // Redirect to admin if already logged in
        }

        return view('admin.login', [
            'title' => 'Đăng Nhập Hệ Thống'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Check if the user is already authenticated
    if (Auth::check()) {
        return redirect()->route('admin'); // Redirect to admin if already logged in
    }

    // Validate the incoming request data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6', // Keep the default rule
        'remember' => 'nullable|boolean', // optional remember me checkbox
    ], [
        'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.', // Custom error message for password
    ]);

    // Attempt to log the user in
    if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
        // Authentication passed, redirect to intended page
        return redirect()->route('admin'); // Make sure 'admin' is a valid route
    }

    // If authentication fails, redirect back with an error message
    return back()->withErrors([
        'email' => 'Tài khoản hoặc mật khẩu không đúng', // Invalid credentials message
    ])->withInput($request->only('email')); // Preserve the email input
}


    public function logout()
    {
        Auth::logout(); // Log the user out
        return redirect()->route('login')->with('success', 'Đăng xuất thành công.'); // Redirect to login page with success message
    }
}
