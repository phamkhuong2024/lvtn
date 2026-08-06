<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'danh_muc';

    protected $fillable = [
        'ten',
        'mota',
        'slug',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $category) {
            if (empty($category->slug) && ! empty($category->ten)) {
                $category->slug = Str::slug($category->ten);
            }
        });

        static::saving(function (self $category) {
            if (empty($category->slug) && ! empty($category->ten)) {
                $category->slug = Str::slug($category->ten);
            }
        });
    }

    public function productTypes()
    {
        return $this->hasMany(ProductType::class, 'danhmucid');
    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'danhmucid');
    }
}
