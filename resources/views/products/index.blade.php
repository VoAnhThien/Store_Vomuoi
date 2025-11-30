<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoMuoi-Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; color: #d35400; }
        .promo-banner { background: linear-gradient(135deg, #e74c3c, #d35400); color: white; }
        .product-card {
            transition: transform 0.3s;
            border: 1px solid #eee;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .original-price { text-decoration: line-through; color: #999; }
        .discount-badge {
            background: #e74c3c;
            color: white;
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1;
        }
        .rating { color: #f39c12; }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">VoMuoi-Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Sofa</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Bàn trà</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Bàn ghế ăn</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Ghế massage</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Thảm</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="#">Khuyến mại HOT</a></li>
                </ul>
                <div class="d-flex">
                    <a href="tel:18001095" class="btn btn-outline-danger me-2">
                        <i class="fas fa-phone"></i> 0355897327
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Promo Banner -->
    <div class="promo-banner py-3">
        <div class="container text-center">
            <h4 class="mb-2">SOFA MỚI - ƯU ĐÃI TỚI 56 TRIỆU</h4>
            <p class="mb-0">Thời gian linh hoạt 3-18 tháng | Áp dụng toàn bộ hệ thống | Thủ tục đơn giản</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-4">
        <!-- Featured Products -->
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-4">SẢN PHẨM NỔI BẬT</h2>
            </div>

            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100">
                    @if($product->original_price && $product->original_price > $product->price)
                    <span class="badge discount-badge">
                        -{{ $product->discount_percentage }}%
                    </span>
                    @endif

                    {{-- <img src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                         class="card-img-top" alt="{{ $product->name }}"> --}}
                         <img src="{{ $product->image ? asset('storage/' . $product->image)
                         : 'https://via.placeholder.com/300x200?text=No+Image' }}">

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text text-muted small mb-1">{{ $product->dimensions }}</p>

                        <div class="rating mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->rating))
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <small>({{ $product->review_count }})</small>
                        </div>

                        <div class="price mb-2">
                            <strong class="text-danger">{{ number_format($product->price, 0, ',', '.') }} đ</strong>
                            @if($product->original_price && $product->original_price > $product->price)
                            <small class="original-price ms-2">{{ number_format($product->original_price, 0, ',', '.') }} đ</small>
                            @endif
                        </div>

                        <p class="text-muted small mb-2">Đã bán: {{ $product->sold_count }}</p>

                        <div class="mt-auto">
                            <div class="d-grid gap-2">
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                                <button class="btn btn-danger btn-sm">Gọi đặt hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>VoMuoi-Home</h5>
                    <p>Chuyên cung cấp các sản phẩm sofa chất lượng cao với giá cả hợp lý.</p>
                </div>
                <div class="col-md-3">
                    <h5>LIÊN HỆ</h5>
                    <p><i class="fas fa-phone"></i> 0355897327</p>
                    <p><i class="fas fa-envelope"></i> vothien817@gmail.com</p>
                </div>
                <div class="col-md-3">
                    <h5>LIÊN KẾT</h5>
                    <ul class="list-unstyled">
                        <li><a href="/admin/dashboard" class="text-light">Admin</a></li>
                        <li><a href="#" class="text-light">Cửa hàng gần bạn</a></li>
                        <li><a href="#" class="text-light">Tin tức</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
