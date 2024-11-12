<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Liên kết với bảng sản phẩm
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liên kết với bảng người dùng
            $table->integer('rating')->default(0); // Điểm đánh giá (sao)
            $table->timestamps();

            // Đảm bảo mỗi người dùng chỉ có thể đánh giá mỗi sản phẩm một lần
            $table->unique(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};
