<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Định nghĩa bảng tương ứng (nếu cần thiết)
    protected $table = 'menus'; // Chỉ định bảng nếu không phải là dạng số nhiều tự động

    // Các thuộc tính có thể được gán hàng loạt
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'content',
        'active',
        'slug' // Đảm bảo rằng 'slug' cũng nằm trong mảng $fillable nếu bạn muốn lưu slug
    ];
    

    // Nếu bạn muốn chuyển đổi một số thuộc tính thành kiểu dữ liệu khác
    protected $casts = [
        'active' => 'boolean', // Chuyển đổi active thành kiểu boolean
        'parent_id' => 'integer'
    ];
}
