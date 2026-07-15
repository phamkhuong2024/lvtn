<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'danh_muc';

    protected $fillable = [
        'ten',
        'mota',
    ];

    public function productTypes()
    {
        return $this->hasMany(ProductType::class, 'danhmucid');
    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'danhmucid');
    }
}
