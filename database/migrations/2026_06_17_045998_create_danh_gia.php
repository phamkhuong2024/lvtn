<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('danh_gia', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

    $table->foreignId('sanphamid')
        ->constrained('san_pham')
        ->cascadeOnDelete();

    $table->foreignId('khachhangid')
        ->constrained('khach_hang')
        ->cascadeOnDelete();

    $table->tinyInteger('sosao');
    $table->text('binhluan')->nullable();

    $table->string('hinhanh')->nullable();

    $table->dateTime('ngaydang')->default(DB::raw('CURRENT_TIMESTAMP'));

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_gia');
    }
};
