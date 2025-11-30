{{-- resources/views/admin/categories/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Thêm Danh mục Mới')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Thêm Danh mục Mới</h1>
            <p class="text-muted mb-0">Thêm danh mục sản phẩm mới vào hệ thống</p>
        </div>
        <a href="{{ route('admin.categories') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}"
                                           placeholder="Nhập tên danh mục" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                        <label class="form-check-label" for="is_active">
                                            Kích hoạt
                                        </label>
                                    </div>
                                    <div class="form-text">
                                        <small>Danh mục sẽ hiển thị trên website khi được kích hoạt</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug URL</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug" value="{{ old('slug') }}"
                                   placeholder="slug-tu-dong-tao">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>Đường dẫn SEO-friendly. Để trống để tự động tạo từ tên danh mục</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Mô tả danh mục</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Mô tả ngắn về danh mục...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Thêm danh mục
                            </button>
                            <a href="{{ route('admin.categories') }}" class="btn btn-secondary">Hủy bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-info"></i>Thông tin
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">Tên danh mục</h6>
                        <p class="text-muted small">Tên hiển thị của danh mục trên website và admin</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-primary">Slug URL</h6>
                        <p class="text-muted small">Đường dẫn thân thiện SEO, ví dụ: <code>sofa-thu-gian</code></p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-primary">Trạng thái</h6>
                        <p class="text-muted small">Kích hoạt để hiển thị trên website, ẩn để tạm thời giấu đi</p>
                    </div>

                    <div class="alert alert-info mt-3">
                        <small>
                            <i class="fas fa-lightbulb me-1"></i>
                            <strong>Mẹo:</strong> Đặt tên danh mục rõ ràng, dễ hiểu để khách hàng dễ tìm kiếm
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const nameInput = this;
    const slugInput = document.getElementById('slug');

    // Only auto-generate if slug is empty or matches the previous auto-generated value
    if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
        const slug = nameInput.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special chars
            .replace(/\s+/g, '-')         // Replace spaces with dashes
            .replace(/-+/g, '-');         // Remove multiple dashes

        slugInput.value = slug;
        slugInput.dataset.autoGenerated = 'true';
    }
});

// Mark slug as manually edited if user types in it
document.getElementById('slug').addEventListener('input', function() {
    this.dataset.autoGenerated = 'false';
});
</script>
@endsection
