<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('khach_hang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
               $table->id();

    $table->string('tendangnhap')->unique();
    $table->string('ten');
    $table->string('email')->unique();
    $table->string('sdt')->nullable();

    $table->string('matkhau');
    $table->date('ngaysinh')->nullable();

    $table->string('gioitinh')->nullable();
    $table->string('diachi')->nullable();

    $table->rememberToken();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khach_hang');
    }
};
