<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_san_pham';

    protected $fillable = [
        'sanphamid',
        'mausacid',
        'kichcoid',
        'soluong',
        'gia',
    ];

    protected $casts = [
        'soluong' => 'integer',
        'gia' => 'decimal:2',
    ];

    public function sanPham()
    {
        return $this->belongsTo(Product::class, 'sanphamid');
    }

    public function mauSac()
    {
        return $this->belongsTo(Color::class, 'mausacid');
    }

    public function kichCo()
    {
        return $this->belongsTo(Size::class, 'kichcoid');
    }
}
