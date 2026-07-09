<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;

    protected $table = 'don_hang';

    protected $fillable = [
        'khachhangid',
        'nhanvienid',
        'khuyenmaiid',
        'ten',
        'email',
        'sdt',
        'diachi',
        'phuong',
        'quan',
        'thanhpho',
        'phigiaohang',
        'tonggia',
        'giamgia',
        'mavandon',
        'trang_thai',
        'phuongthuc',
        'ngaydat',
        'ngaygiao',
        'ngayhuy',
        'ghichu',
    ];

    protected $casts = [
        'phigiaohang' => 'decimal:2',
        'tonggia' => 'decimal:2',
        'giamgia' => 'decimal:2',
        'ngaydat' => 'datetime',
        'ngaygiao' => 'datetime',
        'ngayhuy' => 'datetime',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'khachhangid');
    }

    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'donhangid');
    }

    public function thanhToan()
    {
        return $this->hasOne(ThanhToan::class, 'donhangid');
    }

    public function getMavandonFormattedAttribute()
    {
        if (!empty($this->mavandon)) {
            return $this->mavandon;
        }

        return 'DH' . now()->format('Ymd') . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
