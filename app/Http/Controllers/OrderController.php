<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected array $statuses = [
        'cho_xac_nhan' => 'Chờ xác nhận',
        'dang_xu_ly' => 'Đang xử lý',
        'dang_giao' => 'Đang giao',
        'hoan_thanh' => 'Hoàn thành',
        'da_huy' => 'Đã hủy',
    ];

    public function index(Request $request)
    {
        $query = DonHang::with('khachHang');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ten', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('sdt', 'like', "%{$search}%")
                    ->orWhere('mavandon', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('trang_thai', $request->status);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        $routeGroup = explode('.', $request->route()->getName())[0];
        $statuses = $this->statuses;

        return view('admin.orders.index', compact('orders', 'routeGroup', 'statuses'));
    }

    public function show(Request $request, $id)
    {
        $order = DonHang::with([
            'khachHang',
            'chiTietDonHangs.chiTietSanPham.mauSac',
            'chiTietDonHangs.chiTietSanPham.kichCo',
        ])->findOrFail($id);

        $routeGroup = explode('.', $request->route()->getName())[0];
        $statuses = $this->statuses;

        return view('admin.orders.show', compact('order', 'routeGroup', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'trang_thai' => 'required|in:cho_xac_nhan,dang_xu_ly,dang_giao,hoan_thanh,da_huy',
        ]);

        $order = DonHang::findOrFail($id);
        $order->trang_thai = $request->trang_thai;
        $order->save();

        $routeGroup = explode('.', $request->route()->getName())[0];

        return redirect()->route($routeGroup . '.order.show', $order->id)
            ->with('success', 'Đã cập nhật trạng thái đơn hàng.');
    }

    public function customerIndex()
    {
        $customerId = Auth::guard('khachhang')->id();
        if (!$customerId) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem đơn hàng.');
        }

        $orders = DonHang::with('chiTietDonHangs')
            ->where('khachhangid', $customerId)
            ->orderByDesc('ngaydat')
            ->paginate(10);

        $statuses = $this->statuses;
        return view('khachhang.orders.index', compact('orders', 'statuses'));
    }

    public function customerShow($id)
    {
        $customerId = Auth::guard('khachhang')->id();
        if (!$customerId) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem đơn hàng.');
        }

        $order = DonHang::with([
            'chiTietDonHangs.chiTietSanPham.mauSac',
            'chiTietDonHangs.chiTietSanPham.kichCo',
        ])->where('khachhangid', $customerId)->findOrFail($id);

        $statuses = $this->statuses;
        return view('khachhang.orders.show', compact('order', 'statuses'));
    }

    public function customerCancel($id)
    {
        $customerId = Auth::guard('khachhang')->id();
        if (!$customerId) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để hủy đơn hàng.');
        }

        $order = DonHang::where('khachhangid', $customerId)->findOrFail($id);

        if (in_array($order->trang_thai, ['hoan_thanh', 'da_huy', 'dang_giao'])) {
            return redirect()->route('khachhang.order.show', $order->id)
                ->with('error', 'Đơn hàng không thể hủy ở trạng thái hiện tại.');
        }

        $order->trang_thai = 'da_huy';
        $order->ngayhuy = now();
        $order->save();

        return redirect()->route('khachhang.order.show', $order->id)
            ->with('success', 'Đơn hàng của bạn đã được hủy thành công.');
    }
}
