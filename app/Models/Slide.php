<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $table = 'sliders'; // Specify the correct table name

    protected $fillable = [
        'name',
        'url',
        'thumb',
        'active',
        'sort_by',
        'desc'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
