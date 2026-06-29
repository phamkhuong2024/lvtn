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
        Schema::create('san_pham', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->foreignId('danhmucid')
                ->nullable()
                ->constrained('danh_muc')
                ->nullOnDelete();

            $table->foreignId('loaisanphamid')
                ->constrained('loai_san_pham')
                ->restrictOnDelete();

            $table->string('ten');

            $table->decimal('giaban', 12, 3);
            $table->decimal('giagiam', 12, 3)->nullable();

            $table->string('hinhanh')->nullable();
            $table->text('mota')->nullable();

            $table->boolean('noibat')->default(false);
            $table->boolean('trangthai')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_pham');
    }
};
