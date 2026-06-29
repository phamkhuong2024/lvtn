<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $table = 'kich_co';

    protected $fillable = [
        'ten',
    ];

    public function chiTietSanPhams()
    {
        return $this->hasMany(ProductVariant::class, 'kichcoid');
    }
}
