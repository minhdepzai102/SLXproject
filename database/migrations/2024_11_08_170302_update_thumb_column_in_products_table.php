<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateThumbColumnInProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Thay đổi cột thumb thành TEXT để có thể lưu trữ chuỗi dài
            $table->text('thumb')->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Trở lại kiểu cột trước đây nếu cần
            $table->string('thumb')->change();
        });
    }
}
