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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('quantity')->default(0); // Thêm số lượng
            $table->string('size')->nullable(); // Thêm size, có thể để trống
            $table->string('brand')->nullable(); // Thêm brand, có thể để trống
        });
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'size', 'brand']);
        });
    }
};
