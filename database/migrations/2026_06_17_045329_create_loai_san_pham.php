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
        Schema::create('loai_san_pham', function (Blueprint $table) {
            $table->engine = 'InnoDB';
               $table->id();
                $table->foreignId('danhmucid')
                    ->constrained('danh_muc')
                    ->cascadeOnDelete();

                $table->string('ten');
                $table->text('mota')->nullable();
                $table->string('hinhanh')->nullable();
                $table->boolean('noibat')->default(false);

                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loai_san_pham');
    }
};
