@extends('admin.layouts.app')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quản lý sản phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Thêm sản phẩm mới
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($products->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Chưa có sản phẩm nào</h5>
                <p class="text-muted">Hãy thêm sản phẩm đầu tiên của bạn</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm sản phẩm ngay
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th style="width: 80px;">Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th style="width: 130px;">Giá</th>
                            <th style="width: 150px;">Danh mục</th>
                            <th style="width: 80px;">Đã bán</th>
                            <th style="width: 100px;">Trạng thái</th>
                            <th style="width: 120px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->product_id }}</td>
                            <td>
                                @if($product->image_url)
                                    <img src="{{ asset('storage/' . $product->image_url) }}"
                                         alt="{{ $product->product_name }}"
                                         class="img-thumbnail"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/50?text=No+Image"
                                         alt="No image"
                                         class="img-thumbnail"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->product_name }}</strong>
                                @if($product->is_featured)
                                    <span class="badge bg-warning text-dark ms-1">
                                        <i class="fas fa-star"></i> Nổi bật
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-danger">{{ number_format($product->price, 0, ',', '.') }}đ</strong>
                                @if($product->original_price && $product->original_price > $product->price)
                                    <br>
                                    <small class="text-muted text-decoration-line-through">
                                        {{ number_format($product->original_price, 0, ',', '.') }}đ
                                    </small>
                                @endif
                            </td>
                            <td>
                                @if($product->category)
                                    <span class="badge bg-info text-dark">
                                        {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Chưa phân loại</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ number_format($product->stock ?? 0) }}
                                </span>
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Hiển thị
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle"></i> Ẩn
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.products.edit', $product->product_id) }}"
                                       class="btn btn-primary"
                                       title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.delete', $product->product_id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger"
                                                title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Hiển thị {{ $products->firstItem() }} - {{ $products->lastItem() }}
                    trong tổng số {{ $products->total() }} sản phẩm
                </div>
                <div>
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
