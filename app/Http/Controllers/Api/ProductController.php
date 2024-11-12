<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function rate(Request $request, $productId)
    {
        // Validate rating
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = $validated['rating'];
        $user = Auth::user(); // Get the logged-in user

        // Check if the product exists
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Check if the user has already rated this product
        $existingRating = Rating::where('product_id', $productId)
            ->where('user_id', $user->id)
            ->first();

        if ($existingRating) {
            // If a rating exists, update it
            $existingRating->rating = $rating;
            $existingRating->save();
        } else {
            // If no rating exists, create a new one
            Rating::create([
                'product_id' => $productId,
                'user_id' => $user->id,
                'rating' => $rating,
            ]);
        }

        // Update the average rating and comment count
        $averageRating = $product->ratings()->avg('rating');
        $commentCount = $product->ratings()->count();

        // Decode the thumb field to get the first image
        $thumbs = [];
        if ($product->thumb) {
            // Decode the JSON string within the thumb field
            $thumbs = json_decode($product->thumb, true);
        }

        // Check if thumbs is populated and generate the correct full image URL
        $productImage = !empty($thumbs) ? 'http://127.0.0.1/SLXproject/public/storage/' . $thumbs[0] : null;

        return response()->json([
            'success' => true,
            'new_rating' => number_format($averageRating, 1),
            'comment_count' => $commentCount,
            'product_image' => $productImage,  // Return the first image URL
        ]);
    }

    // Method for searching products
    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::where('name', 'like', "%{$query}%")->get();

        foreach ($products as $product) {
            // Decode the thumb field to get the first image
            $thumbs = [];
            if ($product->thumb) {
                // Decode the JSON string within the thumb field
                $thumbs = json_decode($product->thumb, true);
            }

            // Check if thumbs is populated and generate the correct full image URL
            $product->product_image = !empty($thumbs) ? 'http://127.0.0.1/SLXproject/public/storage/' . $thumbs[0] : null;
        }

        return response()->json($products);
    }
}
