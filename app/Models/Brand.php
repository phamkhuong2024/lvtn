<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'thuong_hieu';

    protected $fillable = [
        'ten',
        'slug',
        'logo',
        'mo_ta',
        'trang_thai',
    ];

    protected $casts = [
        'trang_thai' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->ten);
            }
        });

        static::updating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->ten);
            }
        });
    }

    public function products()
    {
        if (!\Illuminate\Support\Facades\Schema::hasColumn('san_pham', 'thuong_hieu_id')) {
            return $this->hasMany(Product::class, 'id')->whereRaw('1 = 0');
        }
        return $this->hasMany(Product::class, 'thuong_hieu_id');
    }
}
