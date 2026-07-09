<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    use HasFactory;

    protected $table = 'thanh_toan';

    protected $fillable = [
        'donhangid',
        'phuongthuc',
        'sotien',
        'trangthai',
        'ngaythanhtoan',
    ];

    protected $casts = [
        'sotien' => 'decimal:2',
        'ngaythanhtoan' => 'datetime',
    ];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'donhangid');
    }
}
