<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\NhanVien;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
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

    public function getDailyRevenueStats(int $days = 7): array
    {
        $stats = [];

        try {
            $hasDonHangTable = DB::connection()->getSchemaBuilder()->hasTable('don_hang');
        } catch (\Throwable $e) {
            $hasDonHangTable = false;
        }

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $start = $date->copy()->startOfDay();
            $end = $date->copy()->endOfDay();

            if (! $hasDonHangTable) {
                $revenue = 0;
                $orders = 0;
            } else {
                try {
                    $query = DonHang::whereBetween('ngaydat', [$start, $end]);
                    $revenue = (float) $query->sum('tonggia');
                    $orders = (int) $query->count();
                } catch (\Throwable $e) {
                    $revenue = 0;
                    $orders = 0;
                }
            }

            $stats[] = [
                'date' => $date->toDateString(),
                'label' => $date->translatedFormat('d/m'),
                'revenue' => $revenue,
                'orders' => $orders,
            ];
        }

        return $stats;
    }

    public function getEmployeeRevenueStats(): array
    {
        try {
            $hasDonHangTable = DB::connection()->getSchemaBuilder()->hasTable('don_hang');
            $hasNhanVienTable = DB::connection()->getSchemaBuilder()->hasTable('nhan_vien');
        } catch (\Throwable $e) {
            return [];
        }

        if (! $hasDonHangTable || ! $hasNhanVienTable) {
            return [];
        }

        return DonHang::query()
            ->join('nhan_vien', 'nhan_vien.id', '=', 'don_hang.nhanvienid')
            ->select('nhan_vien.id', 'nhan_vien.tennv as name', DB::raw('SUM(don_hang.tonggia) as revenue'), DB::raw('COUNT(don_hang.id) as orders'))
            ->groupBy('nhan_vien.id', 'nhan_vien.tennv')
            ->orderByDesc('revenue')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => (int) $item->id,
                    'name' => (string) $item->name,
                    'revenue' => (float) $item->revenue,
                    'orders' => (int) $item->orders,
                ];
            })
            ->toArray();
    }

    public function getMonthlyRevenueStats(): array
    {
        try {
            $hasDonHangTable = DB::connection()->getSchemaBuilder()->hasTable('don_hang');
        } catch (\Throwable $e) {
            return [];
        }

        if (! $hasDonHangTable) {
            return [];
        }

        $currentYear = now()->year;

        return DonHang::query()
            ->whereYear('ngaydat', $currentYear)
            ->select(
                DB::raw('MONTH(ngaydat) as month'),
                DB::raw('SUM(tonggia) as revenue'),
                DB::raw('COUNT(id) as orders')
            )
            ->groupBy(DB::raw('MONTH(ngaydat)'))
            ->orderBy(DB::raw('MONTH(ngaydat)'))
            ->get()
            ->map(function ($item) {
                return [
                    'month' => (int) $item->month,
                    'label' => now()->month((int) $item->month)->translatedFormat('M'),
                    'revenue' => (float) $item->revenue,
                    'orders' => (int) $item->orders,
                ];
            })
            ->toArray();
    }

    public function getCategoryDistributionStats(): array
    {
        try {
            $hasCategoryTable = DB::connection()->getSchemaBuilder()->hasTable('danh_muc');
            $hasProductTable = DB::connection()->getSchemaBuilder()->hasTable('san_pham');
        } catch (\Throwable $e) {
            return [];
        }

        if (! $hasCategoryTable || ! $hasProductTable) {
            return [];
        }

        return Category::query()
            ->withCount('products')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => (string) $item->ten,
                    'count' => (int) $item->products_count,
                ];
            })
            ->toArray();
    }

    public function adminDashboard()
    {
        $today = now()->startOfDay();
        $revenueToday = DonHang::where('ngaydat', '>=', $today)->sum('tonggia');
        $newOrders = DonHang::where('trang_thai', 'cho_xac_nhan')->count();
        $productCount = Product::count();
        $customerCount = KhachHang::count();
        $latestProducts = Product::with('category')->latest()->take(4)->get();
        $recentOrders = DonHang::with(['khachHang', 'chiTietDonHangs'])->latest('ngaydat')->take(3)->get();
        $dailyRevenueStats = $this->getDailyRevenueStats(7);
        $employeeRevenueStats = $this->getEmployeeRevenueStats();
        $monthlyRevenueStats = $this->getMonthlyRevenueStats();
        $categoryDistributionStats = $this->getCategoryDistributionStats();

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
            'dailyRevenueStats',
            'employeeRevenueStats',
            'monthlyRevenueStats',
            'categoryDistributionStats',
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

        // Load categories with product counts for sidebar
        $categories = Category::withCount(['products'])->get();

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

        // Support filtering by numeric category id (`category_id`) or legacy category keys (`category`)
        if (request()->filled('category_id') && is_numeric(request('category_id'))) {
            $categoryId = (int) request('category_id');
            $query->where('danhmucid', $categoryId);
        } elseif (request()->filled('category')) {
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

        // Filter by product type id (loaisanphamid)
        if (request()->filled('type') && is_numeric(request('type'))) {
            $typeId = (int) request('type');
            $query->where('loaisanphamid', $typeId);
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

        // If a category_id is selected, load its product types for the sidebar
        $productTypes = collect();
        if (isset($categoryId)) {
            $productTypes = ProductType::where('danhmucid', $categoryId)->get();
        }

        return view('products', compact('products', 'categories', 'productTypes'));
    }
}
