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
        Schema::create('chi_tiet_san_pham', function (Blueprint $table) {
            $table->engine = 'InnoDB';
               $table->id();

                $table->foreignId('sanphamid')
                    ->constrained('san_pham')
                    ->cascadeOnDelete();

                $table->foreignId('mausacid')
                    ->constrained('mau_sac')
                    ->restrictOnDelete();

                $table->foreignId('kichcoid')
                    ->constrained('kich_co')
                    ->restrictOnDelete();
                
                $table->integer('soluong')->default(0);
                $table->decimal('gia', 12, 3);

                $table->timestamps();

                $table->unique([
                    'sanphamid',
                    'mausacid',
                    'kichcoid'
                ]);
                    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_san_pham');
    }
};
