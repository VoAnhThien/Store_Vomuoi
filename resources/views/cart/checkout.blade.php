@extends('layouts.app')

@section('title', 'Thanh toán - Sofa VoMuoi-store')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-center mb-10 text-gray-800">Xác nhận đơn hàng</h1>
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Form thông tin -->
        <div class="lg:col-span-2">
            <form action="{{ route('checkout.store') }}" method="POST" class="bg-white rounded-2xl shadow-xl p-8">
                @csrf
                <h2 class="text-2xl font-bold mb-6">Thông tin giao hàng</h2>

                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên *</label>
                        <input type="text" name="customer_name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                               placeholder="Nguyễn Văn A">
                        @error('customer_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                        <input type="text" name="customer_phone" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                               placeholder="0901234567">
                        @error('customer_phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email (không bắt buộc)</label>
                        <input type="email" name="customer_email"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                               placeholder="@gmail.com">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ giao hàng chi tiết *</label>
                        <textarea name="customer_address" required rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                                  placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố"></textarea>
                        @error('customer_address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ghi chú thêm (không bắt buộc)</label>
                        <textarea name="notes" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                                  placeholder="Giao giờ hành chính, để trước cửa..."></textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-4">Phương thức thanh toán</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-500">
                                <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-red-600">
                                <span class="ml-3 text-lg">Thanh toán khi nhận hàng (COD)</span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-500">
                                <input type="radio" name="payment_method" value="bank_transfer" class="w-5 h-5 text-red-600">
                                <span class="ml-3 text-lg">Chuyển khoản ngân hàng</span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500">
                                <input type="radio" name="payment_method" value="momo" class="w-5 h-5 text-purple-600">
                                <img src="https://developers.momo.vn/images/logo.png" class="h-8 ml-3">
                                <span class="ml-3 text-lg">Thanh toán qua MoMo</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('cart.index') }}" class="px-8 py-4 border-2 border-gray-300 rounded-xl font-bold">Quay lại giỏ hàng</a>
                    <button type="submit" class="flex-1 px-8 py-4 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-lg">
                        HOÀN TẤT ĐẶT HÀNG
                    </button>
                </div>
            </form>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div class="bg-gray-50 rounded-2xl p-8 h-fit">
            <h3 class="text-xl font-bold mb-6">Tóm tắt đơn hàng ({{ count($cart) }} sản phẩm)</h3>
            <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                @foreach($cart as $item)
                <div class="flex gap-4 pb-4 border-b">
                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-20 h-20 object-cover rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-500">Số lượng: {{ $item['quantity'] }}</p>
                        <p class="font-bold text-red-600">{{ number_format($item['price'] * $item['quantity']) }} ₫</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="border-t-2 pt-4">
                <div class="flex justify-between text-xl font-bold">
                    <span>Tổng cộng:</span>
                    <span class="text-red-600">{{ number_format($total) }} ₫</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
