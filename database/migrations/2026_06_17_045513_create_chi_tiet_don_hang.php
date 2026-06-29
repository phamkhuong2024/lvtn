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
        Schema::create('chi_tiet_don_hang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->foreignId('donhangid')
                ->constrained('don_hang')
                ->cascadeOnDelete();

            $table->foreignId('chitietsanphamid')
                ->constrained('chi_tiet_san_pham')
                ->cascadeOnDelete();

            $table->integer('soluong');
            $table->decimal('dongia', 12, 3);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_hang');
    }
};
