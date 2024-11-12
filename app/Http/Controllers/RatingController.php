<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function rate(Request $request, $productId)
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'You need to login first']);
        }

        // Kiểm tra rating hợp lệ
        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        // Tìm sản phẩm
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }

        // Kiểm tra nếu người dùng đã đánh giá sản phẩm này chưa
        $existingRating = Rating::where('product_id', $productId)
                                ->where('user_id', Auth::id())
                                ->first();

        if ($existingRating) {
            // Cập nhật lại rating nếu người dùng đã đánh giá trước đó
            $existingRating->rating = $request->rating;
            $existingRating->save();
        } else {
            // Tạo mới rating nếu chưa có
            Rating::create([
                'product_id' => $productId,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
            ]);
        }

        // Tính lại điểm đánh giá trung bình của sản phẩm
        $averageRating = $product->ratings()->avg('rating');
        $averageRating = round($averageRating, 1);

        // Trả về phản hồi
        return response()->json([
            'success' => true,
            'new_rating' => $averageRating,
            'comment_count' => $product->ratings->count(),
        ]);
    }
}
