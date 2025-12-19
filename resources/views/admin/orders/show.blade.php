{{-- Chi tiết đơn hàng --}}
{{-- resources/views/admin/orders/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Chi tiết Đơn hàng #' . $order->order_id)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-file-invoice me-2 text-primary"></i>
                Chi tiết Đơn hàng #{{ $order->order_id }}
            </h1>
            <p class="text-muted mb-0">Thông tin chi tiết đơn hàng của khách hàng</p>
        </div>
        <div>
            <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Details -->
        <div class="col-md-8">
            <!-- Order Items -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Sản phẩm trong đơn
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="80">Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th width="100">Đơn giá</th>
                                    <th width="80">Số lượng</th>
                                    <th width="120">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        @if($item->product->image_url)
                                            <img src="{{ asset('storage/' . $item->product->image_url) }}"
                                                 alt="{{ $item->product->product_name }}"
                                                 class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-0">{{ $item->product->product_name }}</h6>
                                        <small class="text-muted">Màu: {{ $item->product->color ?? 'Không xác định' }}</small>
                                    </td>
                                    <td>{{ number_format($item->unit_price, 0, ',', '.') }}₫</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $item->quantity }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-success">{{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}₫</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                                    <td><strong class="text-success">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Thông tin khách hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Thông tin liên hệ</h6>
                            <p class="mb-1"><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
                            <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $order->customer_email ?? 'Không có' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Địa chỉ giao hàng</h6>
                            <p class="mb-1">{{ $order->shipping_address }}</p>
                            <p class="mb-1"><strong>Phương thức thanh toán:</strong>
                                {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <!-- Order Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tasks me-2"></i>Trạng thái đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $statusColors = [
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'shipped' => 'primary',
                            'delivered' => 'success',
                            'cancelled' => 'danger'
                        ];
                        $statusTexts = [
                            'pending' => 'Chờ xác nhận',
                            'confirmed' => 'Đã xác nhận',
                            'shipped' => 'Đang giao',
                            'delivered' => 'Đã giao',
                            'cancelled' => 'Đã hủy'
                        ];
                    @endphp

                    <div class="text-center mb-3">
                        <span class="badge bg-{{ $statusColors[$order->order_status] }} fs-6">
                            {{ $statusTexts[$order->order_status] }}
                        </span>
                    </div>

                    <form action="{{ route('admin.orders.update-status', $order->order_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label">Cập nhật trạng thái</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Đang giao</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Information -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Thông tin đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Mã đơn hàng:</small>
                        <p class="mb-0"><strong>#{{ $order->order_id }}</strong></p>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Ngày đặt:</small>
                        <p class="mb-0">{{ $order->order_date?->format('d/m/Y H:i') ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Số sản phẩm:</small>
                        <p class="mb-0">{{ $order->items->sum('quantity') }} sản phẩm</p>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Tổng tiền:</small>
                        <p class="mb-0"><strong class="text-success">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong></p>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Ghi chú:</small>
                        <p class="mb-0">{{ $order->notes ?? 'Không có ghi chú' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
