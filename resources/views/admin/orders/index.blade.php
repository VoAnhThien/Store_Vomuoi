{{-- Danh sách đơn hàng --}}
{{-- resources/views/admin/orders/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-shopping-cart me-2 text-primary"></i>Quản lý Đơn hàng</h1>
            <p class="text-muted mb-0">Quản lý và theo dõi đơn hàng của khách hàng</p>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-filter me-2"></i>Lọc đơn hàng
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => '']) }}">Tất cả</a></li>
                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}">Chờ xác nhận</a></li>
                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'confirmed']) }}">Đã xác nhận</a></li>
                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'shipped']) }}">Đang giao</a></li>
                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'delivered']) }}">Đã giao</a></li>
                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}">Đã hủy</a></li>
            </ul>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-muted mb-2">Tổng đơn</h6>
                    <h4 class="mb-0 text-primary">{{ $stats['total'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-muted mb-2">Chờ xác nhận</h6>
                    <h4 class="mb-0 text-warning">{{ $stats['pending'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-muted mb-2">Đã xác nhận</h6>
                    <h4 class="mb-0 text-info">{{ $stats['confirmed'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-muted mb-2">Đang giao</h6>
                    <h4 class="mb-0 text-primary">{{ $stats['shipped'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-muted mb-2">Đã giao</h6>
                    <h4 class="mb-0 text-success">{{ $stats['delivered'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-muted mb-2">Đã hủy</h6>
                    <h4 class="mb-0 text-danger">{{ $stats['cancelled'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="100">Mã đơn</th>
                                <th width="150">Khách hàng</th>
                                <th width="120">Số lượng</th>
                                <th width="150">Tổng tiền</th>
                                <th width="150">Trạng thái</th>
                                <th width="150">Ngày đặt</th>
                                <th width="120" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <strong class="text-primary">#{{ $order->order_id }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-0">{{ $order->customer_name }}</h6>
                                        <small class="text-muted">{{ $order->customer_phone }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $order->items->sum('quantity') }} sản phẩm
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-success">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'shipped' => 'primary',
                                            'delivered' => 'success',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusTexts = [
                                            'pending' => 'Chờ xác nhận',
                                            'confirmed' => 'Đã xác nhận',
                                            'shipped' => 'Đang giao',
                                            'delivered' => 'Đã giao',
                                            'completed' => 'Hoàn thành',
                                            'cancelled' => 'Đã hủy'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$order->order_status] }}">
                                        {{ $statusTexts[$order->order_status] }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $order->order_date->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.orders.show', $order->order_id) }}"
                                           class="btn btn-outline-primary btn-sm"
                                           title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                    type="button"
                                                    data-bs-toggle="dropdown"
                                                    title="Cập nhật trạng thái">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->order_id }}, 'pending')">Chờ xác nhận</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->order_id }}, 'confirmed')">Đã xác nhận</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->order_id }}, 'shipped')">Đang giao</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->order_id }}, 'delivered')">Đã giao</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->order_id }}, 'completed')">Hoàn thành</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="updateStatus({{ $order->order_id }}, 'cancelled')">Hủy đơn</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Hiển thị {{ $orders->firstItem() }} - {{ $orders->lastItem() }}
                        của {{ $orders->total() }} đơn hàng
                    </div>
                    <nav>
                        {{ $orders->links() }}
                    </nav>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có đơn hàng nào</h5>
                    <p class="text-muted">Tất cả đơn hàng của khách hàng sẽ hiển thị tại đây</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function updateStatus(orderId, status) {
    if (confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng?')) {
        fetch(`/admin/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra khi cập nhật trạng thái');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi cập nhật trạng thái');
        });
    }
}
</script>
@endsection
