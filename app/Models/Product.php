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
        'thumb' // Added thumb for thumbnail
    ];

    // Định dạng kiểu dữ liệu
    protected $casts = [
        'price' => 'decimal:2', // Đảm bảo giá có 2 chữ số thập phân
        'price_sale' => 'decimal:2', // Đảm bảo giá khuyến mãi có 2 chữ số thập phân
        'active' => 'boolean',    // Chuyển đổi sang kiểu boolean
    ];

    // Nếu bạn có quan hệ với model khác, ví dụ với Category
    public function category()
    {
        return $this->belongsTo(Menu::class, 'menu_id'); // Relating to the Menu model
    }
}
