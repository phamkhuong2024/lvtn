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
        Schema::create('hinh_anh_san_pham', function (Blueprint $table) {
            $table->engine = 'InnoDB';

        $table->id();

        $table->foreignId('sanphamid')
            ->constrained('san_pham')
            ->cascadeOnDelete();

        $table->foreignId('mausacid')
            ->constrained('mau_sac')
            ->restrictOnDelete();

        $table->string('hinhanh');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hinh_anh_san_pham');
    }
};
