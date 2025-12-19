{{-- resources/views/admin/products/edit.blade.php --}}
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa sản phẩm</h1>
        <a href="{{ route('admin.products') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại danh sách
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin sản phẩm: {{ $product->name }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả sản phẩm</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="price">Giá *</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                           id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="original_price">Giá gốc</label>
                                        <input type="number" class="form-control @error('original_price') is-invalid @enderror"
                                            id="original_price" name="original_price" value="{{ old('original_price', $product->original_price) }}" min="0">
                                        @error('original_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Danh mục *</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="color">Màu sắc</label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror"
                                        id="color" name="color" value="{{ old('color', $product->color) }}">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="dimensions">Kích thước</label>
                                <input type="text" class="form-control @error('dimensions') is-invalid @enderror"
                                    id="dimensions" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="Ví dụ: 140x80x82 cm">
                                @error('dimensions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                                <!-- Hình ảnh -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Hình ảnh sản phẩm</label>
                                    @if($product->image_url)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}"
                                                class="img-thumbnail" style="max-height: 150px;">
                                            <div class="form-check mt-2">
                                                <input type="checkbox" class="form-check-input" id="remove_image" name="remove_image" value="1">
                                                <label class="form-check-label text-danger" for="remove_image">Xóa ảnh hiện tại</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Trạng thái hàng - HIỂN THỊ STOCK -->
                                <div class="form-group">
                                    <label for="stock">Số lượng tồn kho</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                        id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- PHẦN QUAN TRỌNG: TRẠNG THÁI -->
                                <div class="form-group">
                                    <label class="form-label">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                            {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Hiển thị sản phẩm
                                        </label>
                                    </div>
                                </div>

                                {{-- THÊM CHECKBOX is_featured --}}
                                <div class="form-group">
                                    <label class="form-label">Tính năng</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                            {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Sản phẩm nổi bật
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sold_count">Số lượng đã bán</label>
                                    <input type="number" class="form-control @error('sold_count') is-invalid @enderror"
                                           id="sold_count" name="sold_count" value="{{ old('sold_count', $product->sold_count) }}" min="0">
                                    @error('sold_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật sản phẩm
                            </button>
                            <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy bỏ
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
