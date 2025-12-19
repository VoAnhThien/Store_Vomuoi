{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Danh mục')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-edit me-2 text-primary"></i>Chỉnh sửa Danh mục</h1>
            <p class="text-muted mb-0">Cập nhật thông tin danh mục "{{ $category->name }}"</p>
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

                    <form action="{{ route('admin.categories.update', $category->category_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $category->name) }}"
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
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                            {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Kích hoạt
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug URL</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug" value="{{ old('slug', $category->slug) }}"
                                   placeholder="slug-danh-muc">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Mô tả danh mục</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Mô tả ngắn về danh mục...">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh danh mục</label>

                            @if($category->image_url)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $category->image_url) }}"
                                        alt="{{ $category->name }}"
                                        class="img-thumbnail" style="max-height: 150px;">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" id="remove_image" name="remove_image" value="1">
                                        <label class="form-check-label text-danger" for="remove_image">Xóa ảnh hiện tại</label>
                                    </div>
                                </div>
                            @endif

                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>Để trống nếu không thay đổi ảnh</small>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Cập nhật
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
                        <i class="fas fa-chart-bar me-2 text-info"></i>Thống kê
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-light rounded p-3">
                            <h4 class="text-primary mb-1">{{ $category->products->count() }}</h4>
                            <small class="text-muted">Sản phẩm trong danh mục</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Ngày tạo:</small>
                        <p class="mb-1"><strong>{{ optional($category->created_at)->format('d/m/Y') ?? 'N/A' }}</strong></p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Cập nhật lần cuối:</small>
                        <p class="mb-1"><strong>{{ optional($category->updated_at)->format('d/m/Y H:i') ?? 'N/A' }}</strong></p>
                    </div>

                    @if($category->products->count() > 0)
                        <div class="alert alert-warning mt-3">
                            <small>
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                <strong>Lưu ý:</strong> Danh mục này đang chứa {{ $category->products->count() }} sản phẩm.
                                Việc thay đổi có thể ảnh hưởng đến hiển thị sản phẩm.
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto generate slug from name (same as create)
document.getElementById('name').addEventListener('input', function() {
    const nameInput = this;
    const slugInput = document.getElementById('slug');

    if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
        const slug = nameInput.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

        slugInput.value = slug;
        slugInput.dataset.autoGenerated = 'true';
    }
});

document.getElementById('slug').addEventListener('input', function() {
    this.dataset.autoGenerated = 'false';
});
</script>
@endsection
