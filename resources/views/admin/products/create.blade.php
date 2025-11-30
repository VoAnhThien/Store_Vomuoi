{{-- resources/views/admin/products/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">Add SP</h1>
    <a href="{{ route('admin.products') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

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

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <!-- Thông tin cơ bản -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả sản phẩm</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="original_price" class="form-label">Giá gốc</label>
                                <input type="number" class="form-control" id="original_price" name="original_price" value="{{ old('original_price') }}" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Danh mục *</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}"
                                            {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                            {{ $category->name ?? $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="color" class="form-label">Màu sắc</label>
                                <input type="text" class="form-control" id="color" name="color" value="{{ old('color') }}" placeholder="Ví dụ: Màu be, Màu nâu">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="dimensions" class="form-label">Kích thước</label>
                        <input type="text" class="form-control" id="dimensions" name="dimensions" value="{{ old('dimensions') }}" placeholder="Ví dụ: 140x80x82 cm">
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Hình ảnh & Cài đặt -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Chấp nhận: JPG, PNG, GIF (tối đa 2MB)</div>

                        <!-- Preview image -->
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <img id="preview" src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" selected>🟢 Hiển thị - Sản phẩm sẽ hiện trên website</option>
                            <option value="hidden">⚫ Ẩn - Sản phẩm không hiện trên website</option>
                            <option value="draft">📝 Bản nháp - Chỉ admin thấy được</option>
                        </select>
                        <div class="form-text">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                <strong>Hiển thị:</strong> Khách hàng có thể xem và mua |
                                <strong>Ẩn:</strong> Chỉ admin thấy |
                                <strong>Bản nháp:</strong> Đang soạn thảo
                            </small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tính năng</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1">
                            <label class="form-check-label" for="is_featured">
                                Sản phẩm nổi bật
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sold_count" class="form-label">Đã bán</label>
                        <input type="number" class="form-control" id="sold_count" name="sold_count" value="{{ old('sold_count', 0) }}" min="0">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating" class="form-label">Đánh giá</label>
                                <input type="number" class="form-control" id="rating" name="rating" value="{{ old('rating', 0) }}" min="0" max="5" step="0.1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="review_count" class="form-label">Số đánh giá</label>
                                <input type="number" class="form-control" id="review_count" name="review_count" value="{{ old('review_count', 0) }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Thêm sản phẩm
                </button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Hủy bỏ</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Auto calculate discount percentage
    document.getElementById('price').addEventListener('input', calculateDiscount);
    document.getElementById('original_price').addEventListener('input', calculateDiscount);

    function calculateDiscount() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const originalPrice = parseFloat(document.getElementById('original_price').value) || 0;

        if (originalPrice > price) {
            const discount = ((originalPrice - price) / originalPrice * 100).toFixed(0);
            document.getElementById('discount_percentage').textContent = discount + '%';
        }
    }
</script>
@endsection
