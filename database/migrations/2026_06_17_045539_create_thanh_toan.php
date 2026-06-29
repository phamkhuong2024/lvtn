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
        Schema::create('thanh_toan', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->foreignId('donhangid')
                ->constrained('don_hang')
                ->cascadeOnDelete();

            $table->string('phuongthuc');

            $table->decimal('sotien', 12, 3);

            $table->enum('trangthai', [
                'cho_thanh_toan',
                'da_thanh_toan',
                'that_bai',
                'hoan_tien'
            ]);

            $table->timestamp('ngaythanhtoan')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanh_toan');
    }
};
