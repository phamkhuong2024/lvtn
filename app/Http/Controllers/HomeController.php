<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['images.mauSac', 'variants.mauSac', 'variants.kichCo'])
            ->where('noibat', true)
            ->where('trangthai', true)
            ->take(8)
            ->get();

        $newProducts = Product::with(['images.mauSac', 'variants.mauSac', 'variants.kichCo'])
            ->where('trangthai', true)
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('featuredProducts', 'newProducts'));
    }
}
