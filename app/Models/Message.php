<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'sender_id', 'sender_type'];

    // Phương thức trả về người gửi
    public function sender()
    {
        return $this->morphTo();
    }
}
