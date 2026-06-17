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
        Schema::create('khuyen_mai', function (Blueprint $table) {
            $table->engine = 'InnoDB';
               $table->id();

                $table->string('ten');

                $table->enum('loai_khuyen_mai', [
                    'phan_tram',
                    'so_tien'
                ]);

                $table->decimal('giatrigiam', 12, 2);

                $table->decimal('giatridonhang', 12, 2)
                    ->nullable();

                $table->date('ngaybatdau');
                $table->date('ngayketthuc');

                $table->boolean('trangthai')->default(true);

                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khuyen_mai');
    }
};
