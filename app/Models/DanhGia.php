<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;

    protected $table = 'danh_gia';

    protected $fillable = [
        'sanphamid',
        'khachhangid',
        'sosao',
        'binhluan',
        'hinhanh',
        'ngaydang',
    ];

    protected $casts = [
        'ngaydang' => 'datetime',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'khachhangid');
    }

    public function sanPham()
    {
        return $this->belongsTo(Product::class, 'sanphamid');
    }
}
