<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller
{
    protected array $statuses = [
        'cho_xac_nhan' => 'Chờ xác nhận',
        'dang_xu_ly' => 'Đang xử lý',
        'dang_giao' => 'Đang giao',
        'hoan_thanh' => 'Hoàn thành',
        'da_huy' => 'Đã hủy',
    ];

    public function adminDashboard()
    {
        $today = now()->startOfDay();
        $revenueToday = DonHang::where('ngaydat', '>=', $today)->sum('tonggia');
        $newOrders = DonHang::where('trang_thai', 'cho_xac_nhan')->count();
        $productCount = Product::count();
        $customerCount = KhachHang::count();
        $latestProducts = Product::with('category')->latest()->take(4)->get();
        $recentOrders = DonHang::with(['khachHang', 'chiTietDonHangs'])->latest('ngaydat')->take(3)->get();

        $currentYear = now()->year;
        $currentMonth = now()->month;
        $currentQuarter = ceil($currentMonth / 3);
        $quarterStart = ($currentQuarter - 1) * 3 + 1;
        $quarterEnd = $currentQuarter * 3;

        $monthlyRevenue = DonHang::whereYear('ngaydat', $currentYear)->whereMonth('ngaydat', $currentMonth)->sum('tonggia');
        $monthlyOrders = DonHang::whereYear('ngaydat', $currentYear)->whereMonth('ngaydat', $currentMonth)->count();
        $quarterRevenue = DonHang::whereYear('ngaydat', $currentYear)->whereBetween(DB::raw('MONTH(ngaydat)'), [$quarterStart, $quarterEnd])->sum('tonggia');
        $quarterOrders = DonHang::whereYear('ngaydat', $currentYear)->whereBetween(DB::raw('MONTH(ngaydat)'), [$quarterStart, $quarterEnd])->count();
        $yearlyRevenue = DonHang::whereYear('ngaydat', $currentYear)->sum('tonggia');
        $yearlyOrders = DonHang::whereYear('ngaydat', $currentYear)->count();

        return view('admin.dashboard', compact(
            'revenueToday',
            'newOrders',
            'productCount',
            'customerCount',
            'latestProducts',
            'recentOrders',
            'monthlyRevenue',
            'monthlyOrders',
            'quarterRevenue',
            'quarterOrders',
            'yearlyRevenue',
            'yearlyOrders',
            'currentQuarter',
            'currentYear'
        ));
    }

    public function products()
    {
        $query = Product::where('trangthai', true);

        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('ten', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('ten', 'like', "%{$search}%");
                    })
                    ->orWhereHas('type', function ($q) use ($search) {
                        $q->where('ten', 'like', "%{$search}%");
                    });
            });
        }

        if (request()->filled('category')) {
            $categoryKey = request('category');
            $categoryMap = [
                'ao' => 'Áo',
                'quan' => 'Quần',
                'vay' => 'Váy',
                'phukien' => 'Phụ kiện',
            ];

            if (isset($categoryMap[$categoryKey])) {
                $categoryName = $categoryMap[$categoryKey];
                $query->where(function ($q) use ($categoryName) {
                    $q->whereHas('category', function ($q2) use ($categoryName) {
                        $q2->where('ten', $categoryName);
                    })
                    ->orWhereHas('type', function ($q2) use ($categoryName) {
                        $q2->where('ten', 'like', "%{$categoryName}%");
                    });
                });
            }
        }

        if (request()->filled('price')) {
            $price = request('price');
            $ranges = [
                '200000-500000' => [200000, 500000],
                '500000-1000000' => [500000, 1000000],
            ];

            if (isset($ranges[$price])) {
                [$minPrice, $maxPrice] = $ranges[$price];
                $query->whereRaw('COALESCE(giagiam, giaban) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
            }
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('products', compact('products'));
    }
}
