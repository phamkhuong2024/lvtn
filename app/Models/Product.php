<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'san_pham';

    protected $fillable = [
        'danhmucid',
        'loaisanphamid',
        'ten',
        'giaban',
        'giagiam',
        'hinhanh',
        'mota',
        'noibat',
        'trangthai',
    ];

    protected $casts = [
        'giaban' => 'decimal:2',
        'giagiam' => 'decimal:2',
        'noibat' => 'boolean',
        'trangthai' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'danhmucid');
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'loaisanphamid');
    }
}
