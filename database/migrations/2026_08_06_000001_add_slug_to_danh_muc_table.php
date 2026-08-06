<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('danh_muc')) {
            return;
        }

        if (! Schema::hasColumn('danh_muc', 'slug')) {
            Schema::table('danh_muc', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique();
            });
        }

        $categories = DB::table('danh_muc')->whereNull('slug')->orWhere('slug', '')->get();

        foreach ($categories as $category) {
            $slug = Str::slug($category->ten ?? '');

            if ($slug === '') {
                $slug = 'danh-muc-' . ($category->id ?? 0);
            }

            DB::table('danh_muc')->where('id', $category->id)->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('danh_muc')) {
            return;
        }

        if (Schema::hasColumn('danh_muc', 'slug')) {
            Schema::table('danh_muc', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
