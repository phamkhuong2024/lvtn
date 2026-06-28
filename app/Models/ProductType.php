<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $table = 'loai_san_pham';

    protected $fillable = [
        'danhmucid',
        'ten',
        'mota',
        'hinhanh',
        'noibat',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'danhmucid');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'loaisanphamid');
    }
}
