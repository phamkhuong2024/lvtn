<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $table = 'mau_sac';

    protected $fillable = [
        'ma_mau',
        'ten',
    ];

    public function chiTietSanPhams()
    {
        return $this->hasMany(ProductVariant::class, 'mausacid');
    }
}
