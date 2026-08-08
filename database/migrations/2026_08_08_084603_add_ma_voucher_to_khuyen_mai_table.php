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
        Schema::table('khuyen_mai', function (Blueprint $table) {
            $table->string('ma_voucher', 50)->nullable()->after('ten');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('khuyen_mai', function (Blueprint $table) {
            $table->dropColumn('ma_voucher');
        });
    }
};
