<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_don_hang';

    protected $fillable = [
        'donhangid',
        'chitietsanphamid',
        'soluong',
        'dongia',
    ];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'donhangid');
    }

    public function chiTietSanPham()
    {
        return $this->belongsTo(ProductVariant::class, 'chitietsanphamid');
    }
}
