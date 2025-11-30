<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - VoMuoi-Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .product-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">VoMuoi-Home</a>
            <a href="/" class="btn btn-outline-primary">← Quay lại trang chủ</a>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-6">
                {{-- SỬA LỖI Ở ĐÂY: Thêm dấu ngoặc nhọn đóng --}}
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/500x400?text=No+Image' }}"
                     class="product-image" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p class="text-muted">{{ $product->dimensions }}</p>

                <div class="price mb-3">
                    <h2 class="text-danger">{{ number_format($product->price, 0, ',', '.') }} đ</h2>
                    @if($product->original_price && $product->original_price > $product->price)
                    <del class="text-muted">{{ number_format($product->original_price, 0, ',', '.') }} đ</del>
                    <span class="badge bg-danger">-{{ $product->discount_percentage }}%</span>
                    @endif
                </div>

                <div class="mb-3">
                    <strong>Màu sắc:</strong> {{ $product->color }}
                </div>

                <div class="mb-3">
                    <strong>Mô tả:</strong>
                    <p>{{ $product->description ?: 'Sản phẩm chất lượng cao, thiết kế hiện đại.' }}</p>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-danger btn-lg">Gọi đặt hàng: 0355897327</button>
                    <a href="/" class="btn btn-outline-primary">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
