<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'hinh_anh_san_pham';

    protected $fillable = [
        'sanphamid',
        'mausacid',
        'hinhanh',
        'public_id',
    ];

    public function sanPham()
    {
        return $this->belongsTo(Product::class, 'sanphamid');
    }

    public function mauSac()
    {
        return $this->belongsTo(Color::class, 'mausacid');
    }
}
