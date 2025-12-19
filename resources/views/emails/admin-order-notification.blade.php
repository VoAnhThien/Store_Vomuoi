<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .order-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .order-info table {
            width: 100%;
        }
        .order-info td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
        }
        .products {
            margin: 20px 0;
        }
        .product-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .total {
            background: #fff3cd;
            padding: 15px;
            border-radius: 6px;
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #dc3545;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 ĐƠN HÀNG MỚI</h1>
            <p>Vừa có đơn hàng mới từ website!</p>
        </div>

        <div class="content">
            <h2 style="color: #dc3545;">Mã đơn hàng: {{ $order->order_code }}</h2>
            <p>Thời gian: {{ $order->created_at->format('d/m/Y H:i:s') }}</p>

            <div class="order-info">
                <h3>📋 Thông tin khách hàng</h3>
                <table>
                    <tr>
                        <td><strong>Họ tên:</strong></td>
                        <td>{{ $order->customer_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Số điện thoại:</strong></td>
                        <td>{{ $order->customer_phone }}</td>
                    </tr>
                    @if($order->customer_email)
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $order->customer_email }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Địa chỉ:</strong></td>
                        <td>{{ $order->customer_address }}</td>
                    </tr>
                    <tr>
                        <td><strong>Thanh toán:</strong></td>
                        <td>{{ $order->payment_method === 'cod' ? 'COD' : 'Chuyển khoản' }}</td>
                    </tr>
                </table>
            </div>

            <div class="products">
                <h3>🛍️ Sản phẩm đã đặt</h3>
                @foreach($order->items as $item)
                <div class="product-item">
                    <strong>{{ $item->product->product_name ?? 'Sản phẩm' }}</strong><br>
                    Số lượng: {{ $item->quantity }} x {{ number_format($item->price) }} ₫
                    = <strong>{{ number_format($item->price * $item->quantity) }} ₫</strong>
                </div>
                @endforeach
            </div>

            <div class="total">
                Tổng: {{ number_format($order->total_amount) }} ₫
            </div>

            @if($order->notes)
            <div style="background: #fff3cd; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <strong>📝 Ghi chú:</strong><br>
                {{ $order->notes }}
            </div>
            @endif

            <div style="text-align: center;">
                <a href="{{ url('/admin/orders/' . $order->order_id) }}" class="btn">
                    XEM CHI TIẾT ĐƠN HÀNG
                </a>
            </div>

            <p style="color: #dc3545; font-weight: bold; text-align: center; margin-top: 20px;">
                ⚠️ VUI LÒNG LIÊN HỆ KHÁCH HÀNG TRONG VÒNG 2 GIỜ
            </p>
        </div>
    </div>
</body>
</html>
