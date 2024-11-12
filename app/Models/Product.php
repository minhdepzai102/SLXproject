<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Các thuộc tính có thể được gán hàng loạt
    protected $fillable = [
        'name',
        'description',
        'content', // Added content
        'menu_id', // Added menu_id
        'price',
        'price_sale', // Added price_sale
        'active',
        'thumb', // Added thumb for thumbnail
        'quantity', // Added quantity
        'size', // Added size
        'brand', // Added brand
    ];
    

    // Định dạng kiểu dữ liệu
    protected $casts = [
        'price' => 'decimal:2', // Đảm bảo giá có 2 chữ số thập phân
        'price_sale' => 'decimal:2', // Đảm bảo giá khuyến mãi có 2 chữ số thập phân
        'active' => 'boolean',    // Chuyển đổi sang kiểu boolean
        'thumb' => 'array', // Ensure thumb is treated as an array
    ];

    // Quan hệ với ProductImage
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Quan hệ với Menu (Danh mục)
    public function category()
    {
        return $this->belongsTo(Menu::class, 'menu_id'); // Relating to the Menu model
    }

    // Accessor for thumb (retrieves as array)
    public function getThumbAttribute($value)
    {
        return json_decode($value, true); // Decode JSON string into an array
    }

    // Mutator for thumb (sets as JSON)
    public function setThumbAttribute($value)
    {
        $this->attributes['thumb'] = json_encode($value); // Encode array to JSON
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Phương thức để tính trung bình số sao
    public function averageRating()
    {
        // Tính trung bình số sao từ các đánh giá
        return $this->ratings->avg('rating') ?: 0; // Trả về 0 nếu không có đánh giá
    }
    
}
