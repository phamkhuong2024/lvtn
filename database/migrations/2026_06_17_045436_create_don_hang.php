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
        Schema::create('don_hang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
                $table->id();

    $table->foreignId('khachhangid')
        ->constrained('khach_hang')
        ->cascadeOnDelete();

    $table->foreignId('nhanvienid')
        ->nullable()
        ->constrained('nhan_vien')
        ->nullOnDelete();

    $table->foreignId('khuyenmaiid')
        ->nullable()
        ->constrained('khuyen_mai')
        ->nullOnDelete();

    $table->string('ten');
    $table->string('email');
    $table->string('sdt');

    $table->string('diachi');
    $table->string('phuong')->nullable();
    $table->string('quan')->nullable();
    $table->string('thanhpho')->nullable();

    $table->decimal('phigiaohang', 12, 2)->default(0);
    $table->decimal('tonggia', 12, 2);
    $table->decimal('giamgia', 12, 2)->default(0);

    $table->string('mavandon')->nullable();

    $table->enum('trang_thai', [
        'cho_xac_nhan',
        'dang_xu_ly',
        'dang_giao',
        'hoan_thanh',
        'da_huy'
    ])->default('cho_xac_nhan');

    $table->string('phuongthuc')->nullable();

    $table->dateTime('ngaydat');
    $table->dateTime('ngaygiao')->nullable();
    $table->dateTime('ngayhuy')->nullable();

    $table->text('ghichu')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_hang');
    }
};
