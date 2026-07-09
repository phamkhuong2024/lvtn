@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="mb-3">Đơn hàng của tôi</h3>
                    @if($orders->isEmpty())
                        <p>Bạn chưa có đơn hàng nào.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->mavandon_formatted }}</td>
                                            <td>{{ optional($order->ngaydat)->format('d/m/Y H:i') }}</td>
                                            <td>{{ $statuses[$order->trang_thai] ?? $order->trang_thai }}</td>
                                            <td>{{ number_format($order->tonggia, 0, ',', '.') }}₫</td>
                                            <td><a href="{{ route('khachhang.order.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Xem chi tiết</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
