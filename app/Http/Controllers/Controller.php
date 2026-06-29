<?php

namespace App\Http\Controllers;

use App\Models\Product;

class Controller
{
   

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function products()
    {
        $products = Product::where('trangthai', true)
            ->latest()
            ->get();

        return view('products', compact('products'));
    }
}
