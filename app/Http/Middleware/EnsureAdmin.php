<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Dùng dd() hoặc dump() để kiểm tra
        dd('Middleware is working!');
        // Hoặc dump thông tin user
        dump($request->user());

        // Tiến hành kiểm tra quyền hoặc điều kiện khác
        if ($request->user() && $request->user()->role !== 1) {
            return redirect('home');
        }

        // Nếu mọi thứ ổn, tiếp tục với request
        return $next($request);
    }
}
