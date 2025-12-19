@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-md-3 mb-4">
        <div class="card text-white shadow-lg border-0" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1">Sản phẩm</h6>
                    <h2 class="fw-bold">{{ $stats['total_products'] }}</h2>
                </div>
                <div class="bg-white rounded-circle p-3">
                    <i class="fas fa-couch fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white shadow-lg border-0" style="background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1">Danh mục</h6>
                    <h2 class="fw-bold">{{ $stats['total_categories'] }}</h2>
                </div>
                <div class="bg-white rounded-circle p-3">
                    <i class="fas fa-list fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white shadow-lg border-0" style="background: linear-gradient(135deg, #36b9cc 0%, #2c9faf 100%);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1">Đã bán</h6>
                    <h2 class="fw-bold">{{ $stats['total_sales'] }}</h2>
                </div>
                <div class="bg-white rounded-circle p-3">
                    <i class="fas fa-shopping-cart fa-2x text-info"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white shadow-lg border-0" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1">Doanh thu</h6>
                    <h2 class="fw-bold">{{ number_format($stats['revenue'], 0, ',', '.') }} đ</h2>
                </div>
                <div class="bg-white rounded-circle p-3">
                    <i class="fas fa-money-bill-wave fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Products -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Sản phẩm mới nhất</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Ngày thêm</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td><span class="badge bg-success">{{ number_format($product->price, 0, ',', '.') }} đ</span></td>
                                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Sản phẩm bán chạy</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Đã bán</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($top_selling as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td><span class="badge bg-info">{{ $product->sold_count }}</span></td>
                                <td><span class="badge bg-warning text-dark">{{ number_format($product->price * $product->sold_count, 0, ',', '.') }} đ</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
