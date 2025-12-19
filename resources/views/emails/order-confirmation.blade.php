<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .success-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }
        .content {
            padding: 30px;
        }
        .order-code {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .order-code strong {
            color: #667eea;
            font-size: 20px;
        }
        .info-section {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .info-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 16px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 8px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #666;
            font-weight: 500;
        }
        .info-value {
            color: #333;
            text-align: right;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .products-table th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 500;
        }
        .products-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .products-table tr:last-child td {
            border-bottom: none;
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
        .total-section {
            background: #fff3cd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: right;
        }
        .total-amount {
            font-size: 28px;
            color: #dc3545;
            font-weight: bold;
        }
        .payment-method {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .bank-info {
            background: #cce5ff;
            border: 1px solid #b8daff;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .bank-info strong {
            color: #004085;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            color: #856404;
        }
        @media only screen and (max-width: 600px) {
            .container {
                border-radius: 0;
            }
            .content {
                padding: 20px;
            }
            .products-table {
                font-size: 12px;
            }
            .product-image {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="success-icon">✓</div>
            <h1>🎉 Đặt hàng thành công!</h1>
            <p>Cảm ơn bạn đã tin tưởng VoMuoi Store</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p style="font-size: 16px; color: #333; margin-bottom: 20px;">
                Xin chào <strong>{{ $order->customer_name }}</strong>,
            </p>
            <p style="color: #666; line-height: 1.6;">
                Chúng tôi đã nhận được đơn hàng của bạn và đang xử lý.
                Đội ngũ của chúng tôi sẽ liên hệ với bạn trong vòng <strong>2-4 giờ</strong> để xác nhận.
            </p>

            <!-- Order Code -->
            <div class="order-code">
                <div style="color: #666; margin-bottom: 5px;">Mã đơn hàng của bạn:</div>
                <strong>{{ $order->order_code }}</strong>
            </div>

            <!-- Customer Info -->
            <div class="info-section">
                <h3>📋 Thông tin người nhận</h3>
                <div class="info-row">
                    <span class="info-label">Họ và tên:</span>
                    <span class="info-value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số điện thoại:</span>
                    <span class="info-value">{{ $order->customer_phone }}</span>
                </div>
                @if($order->customer_email)
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $order->customer_email }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Địa chỉ giao hàng:</span>
                    <span class="info-value">{{ $order->customer_address }}</span>
                </div>
            </div>

            <!-- Products -->
            <h3 style="margin: 25px 0 15px; color: #333;">🛍️ Chi tiết đơn hàng</h3>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th style="text-align: right;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                @if($item->product && $item->product->image_url)
                                <img src="{{ asset('storage/' . $item->product->image_url) }}"
                                     alt="{{ $item->product->product_name }}"
                                     class="product-image">
                                @endif
                                <div>
                                    <strong>{{ $item->product->product_name ?? 'Sản phẩm' }}</strong><br>
                                    <span style="color: #666; font-size: 13px;">{{ number_format($item->price) }} ₫</span>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: center;">x{{ $item->quantity }}</td>
                        <td style="text-align: right; font-weight: bold; color: #dc3545;">
                            {{ number_format($item->price * $item->quantity) }} ₫
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total -->
            <div class="total-section">
                <div style="color: #666; margin-bottom: 5px;">Tổng thanh toán:</div>
                <div class="total-amount">{{ number_format($order->total_amount) }} ₫</div>
            </div>

            <!-- Payment Method -->
            <div class="payment-method">
                <strong>💳 Phương thức thanh toán:</strong><br>
                @if($order->payment_method === 'cod')
                    ✅ Thanh toán khi nhận hàng (COD)
                @else
                    🏦 Chuyển khoản ngân hàng
                    <div class="bank-info" style="margin-top: 10px;">
                        <strong>Thông tin chuyển khoản:</strong><br>
                        <strong>Ngân hàng:</strong> Techcombank<br>
                        <strong>Số TK:</strong> 0123456789<br>
                        <strong>Chủ TK:</strong> NGUYEN VAN A<br>
                        <strong>Số tiền:</strong> <span style="color: #dc3545; font-weight: bold;">{{ number_format($order->total_amount) }} ₫</span><br>
                        <strong>Nội dung:</strong> {{ $order->order_code }} {{ $order->customer_phone }}
                    </div>
                @endif
            </div>

            @if($order->notes)
            <div class="note">
                <strong>📝 Ghi chú của bạn:</strong><br>
                {{ $order->notes }}
            </div>
            @endif

            <!-- Important Info -->
            <div style="background: #e7f3ff; border-left: 4px solid #2196F3; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <strong style="color: #0c5460;">ℹ️ Lưu ý quan trọng:</strong>
                <ul style="margin: 10px 0 0 20px; color: #0c5460;">
                    <li>Thời gian giao hàng dự kiến: <strong>3-5 ngày làm việc</strong></li>
                    <li>Vui lòng giữ điện thoại để nhận cuộc gọi xác nhận</li>
                    <li>Nếu có thắc mắc, vui lòng liên hệ: <strong>1900 xxxx</strong></li>
                </ul>
            </div>

            <p style="text-align: center; margin-top: 30px; color: #666;">
                Cảm ơn bạn đã lựa chọn VoMuoi Store! ❤️
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>VoMuoi Store</strong></p>
            <p>Địa chỉ: Hoài Đức, Hoài Nhơn, Bình Định</p>
            <p>Hotline: 0355897327 | Email: vothien817@gmail.com</p>
            <p style="margin-top: 15px;">
                <a href="https://facebook.com/vomuoistore">Facebook</a> |
                <a href="https://instagram.com/vomuoistore">Instagram</a> |
                <a href="https://vomuoistore.com">Website</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                Email này được gửi tự động, vui lòng không trả lời.
            </p>
        </div>
    </div>
</body>
</html>
