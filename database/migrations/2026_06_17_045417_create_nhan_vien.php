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
        Schema::create('nhan_vien', function (Blueprint $table) {
            $table->engine = 'InnoDB';
           $table->id();

    $table->string('tennv');
    $table->string('email')->unique();
    $table->string('sdt')->nullable();

    $table->string('matkhau');
    $table->string('gioitinh')->nullable();

    $table->string('diachi')->nullable();
    $table->string('chucvu')->nullable();

    $table->date('ngayvaolam')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_vien');
    }
};
