<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'image_path'];

    // Define the inverse relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
