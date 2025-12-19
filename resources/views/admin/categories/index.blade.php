{{-- resources/views/admin/categories/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-tags me-2 text-primary"></i>Quản lý Danh mục</h1>
            <p class="text-muted mb-0">Quản lý danh mục sản phẩm trong hệ thống</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm danh mục
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-shadow border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted mb-2">Tổng danh mục</h6>
                            <h4 class="mb-0">{{ $categories->total() }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-tags fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-shadow border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted mb-2">Đang hoạt động</h6>
                            <h4 class="mb-0">{{ $categories->where('is_active', 1)->count() }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card card-shadow border-0">
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="80">ID</th>
                                <th>Tên danh mục</th>
                                <th width="120">Số sản phẩm</th>
                                <th width="120">Trạng thái</th>
                                <th width="150">Ngày tạo</th>
                                <th width="120" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    <span class="fw-bold text-muted">#{{ $category->category_id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $category->name }}</h6>
                                            @if($category->slug)
                                                <small class="text-muted">{{ $category->slug }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $category->products_count ?? $category->products->count() }}
                                    </span>
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success status-badge">
                                            <i class="fas fa-check me-1"></i>Hoạt động
                                        </span>
                                    @else
                                        <span class="badge bg-secondary status-badge">
                                            <i class="fas fa-times me-1"></i>Ẩn
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ optional($category->created_at)->format('d/m/Y') ?? 'N/A' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->category_id) }}"
                                           class="btn btn-outline-primary btn-action"
                                           title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.delete', $category->category_id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-action" title="Xóa">
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
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Hiển thị {{ $categories->firstItem() }} - {{ $categories->lastItem() }}
                        của {{ $categories->total() }} danh mục
                    </div>
                    <nav>
                        {{ $categories->links() }}
                    </nav>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có danh mục nào</h5>
                    <p class="text-muted mb-4">Bắt đầu bằng cách thêm danh mục đầu tiên của bạn</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm danh mục đầu tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
