@extends('admin.layouts.app')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="flex items-center justify-between flex-wrap gap-4 pt-3 pb-2 mb-6">
    <h1 class="text-2xl font-bold">Quản lý sản phẩm</h1>
    <a href="{{ route('admin.products.create') }}"
       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        <i class="fas fa-plus mr-2"></i> Thêm sản phẩm
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white shadow rounded-lg">
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Hình ảnh</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tên sản phẩm</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Giá</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Danh mục</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Đã bán</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Trạng thái</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $product)
                <tr>
                    <td class="px-4 py-2">{{ $product->id }}</td>
                    <td class="px-4 py-2">
                        @if($product->image_url)
                            <img src="{{ asset('storage/products/' . $product->image_url) }}"
                                 alt="{{ $product->name }}"
                                 class="w-12 h-12 object-cover rounded">
                        @else
                            <img src="https://via.placeholder.com/50" alt="No image"
                                 class="w-12 h-12 object-cover rounded">
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2 text-red-600 font-semibold">
                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </td>
                    <td class="px-4 py-2">
                        {{ $product->category ? $product->category->name : 'Không có' }}
                    </td>
                    <td class="px-4 py-2">{{ $product->sold_count }}</td>
                    <td class="px-4 py-2">
                        @if($product->is_active)
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded">
                                Hiển thị
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-700 rounded">
                                Ẩn
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.products.edit', $product->product_id) }}"
                           class="inline-flex items-center px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.delete', $product->product_id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition"
                                    onclick="return confirm('Bạn có chắc muốn xóa?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
