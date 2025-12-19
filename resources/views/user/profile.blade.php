@extends('layouts.app')

@section('title', 'Tài khoản của tôi')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Tài khoản của tôi</h1>
            <p class="text-gray-600 mt-1">Quản lý thông tin cá nhân và bảo mật</p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sidebar Menu -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center space-x-3 pb-4 border-b">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="Avatar" class="w-12 h-12 rounded-full">
                        @else
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-xl font-bold text-gray-600">{{ substr($user->fullname, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-900">{{ $user->fullname }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>

                    <nav class="mt-4 space-y-1">
                        <a href="#info" onclick="showTab('info')" id="tab-info"
                           class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium tab-link active">
                            <i class="fas fa-user mr-3"></i>
                            Thông tin cá nhân
                        </a>
                        @if($user->provider === 'local')
                        <a href="#password" onclick="showTab('password')" id="tab-password"
                           class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium tab-link">
                            <i class="fas fa-lock mr-3"></i>
                            Đổi mật khẩu
                        </a>
                        @endif
                        <a href="{{ route('user.orders') }}"
                           class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                            <i class="fas fa-shopping-bag mr-3"></i>
                            Đơn hàng của tôi
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Thông tin cá nhân -->
                <div id="content-info" class="bg-white rounded-lg shadow-sm p-6 tab-content">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Thông tin cá nhân</h2>

                    <form method="POST" action="{{ route('user.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên *</label>
                                <input type="text" name="fullname" value="{{ old('fullname', $user->fullname) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('fullname')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" value="{{ $user->email }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100"
                                       disabled>
                                @if($user->provider === 'google')
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fab fa-google mr-1"></i> Đăng nhập bằng Google
                                    </p>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                                <textarea name="address" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                    <i class="fas fa-save mr-2"></i>
                                    Lưu thay đổi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Đổi mật khẩu -->
                @if($user->provider === 'local')
                <div id="content-password" class="bg-white rounded-lg shadow-sm p-6 tab-content hidden">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Đổi mật khẩu</h2>

                    <form method="POST" action="{{ route('user.change-password') }}">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu hiện tại *</label>
                                <input type="password" name="current_password"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('current_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới *</label>
                                <input type="password" name="new_password"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('new_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu mới *</label>
                                <input type="password" name="new_password_confirmation"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                    <i class="fas fa-key mr-2"></i>
                                    Đổi mật khẩu
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-link').forEach(el => el.classList.remove('active', 'bg-blue-50', 'text-blue-600'));

    // Show selected content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    document.getElementById('tab-' + tabName).classList.add('active', 'bg-blue-50', 'text-blue-600');
}
</script>

<style>
.tab-link.active {
    background-color: #eff6ff;
    color: #2563eb;
}
</style>
@endsection
