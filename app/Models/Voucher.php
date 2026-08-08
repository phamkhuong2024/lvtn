<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'khuyen_mai';

    protected $fillable = [
        'ten',
        'ma_voucher',
        'loai_khuyen_mai',
        'giatrigiam',
        'giatridonhang',
        'ngaybatdau',
        'ngayketthuc',
        'trangthai',
    ];

    protected $casts = [
        'giatrigiam' => 'decimal:2',
        'giatridonhang' => 'decimal:2',
        'ngaybatdau' => 'date',
        'ngayketthuc' => 'date',
        'trangthai' => 'boolean',
    ];

    /**
     * Check if voucher is currently active
     */
    public function isActive()
    {
        $now = now();
        return $this->trangthai 
            && $this->ngaybatdau <= $now 
            && $this->ngayketthuc >= $now;
    }

    /**
     * Check if voucher is applicable to order amount
     */
    public function isApplicable($orderAmount)
    {
        if (!$this->isActive()) {
            return false;
        }

        if ($this->giatridonhang && $orderAmount < $this->giatridonhang) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount($orderAmount)
    {
        if (!$this->isApplicable($orderAmount)) {
            return 0;
        }

        if ($this->loai_khuyen_mai === 'phan_tram') {
            return $orderAmount * ($this->giatrigiam / 100);
        }

        return $this->giatrigiam;
    }

    /**
     * Get orders using this voucher
     */
    public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'khuyenmaiid');
    }
}
