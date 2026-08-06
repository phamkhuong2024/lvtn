<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('thuong_hieu')) {
            Schema::create('thuong_hieu', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->string('ten');
                $table->string('slug')->unique()->nullable();
                $table->string('logo')->nullable();
                $table->text('mo_ta')->nullable();
                $table->boolean('trang_thai')->default(true);
                $table->timestamps();
            });
        }

        Schema::table('san_pham', function (Blueprint $table) {
            if (!Schema::hasColumn('san_pham', 'thuong_hieu_id')) {
                $table->unsignedBigInteger('thuong_hieu_id')->nullable()->after('loaisanphamid');
                $table->foreign('thuong_hieu_id')
                    ->references('id')
                    ->on('thuong_hieu')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('san_pham', function (Blueprint $table) {
            if (Schema::hasColumn('san_pham', 'thuong_hieu_id')) {
                $table->dropForeign(['thuong_hieu_id']);
                $table->dropColumn('thuong_hieu_id');
            }
        });

        Schema::dropIfExists('thuong_hieu');
    }
};
