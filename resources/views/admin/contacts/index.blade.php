@extends('admin.layouts.app')

@section('title', 'Quản lý liên hệ')

@section('content')
<div class="container-fluid">
    <!-- Thông báo -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Thống kê -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tổng liên hệ</h6>
                            <h3 class="mb-0">{{ $contacts->total() }}</h3>
                        </div>
                        <i class="fas fa-envelope fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Hôm nay</h6>
                            <h3 class="mb-0">{{ App\Models\Contact::whereDate('created_at', today())->count() }}</h3>
                        </div>
                        <i class="fas fa-paper-plane fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tuần này</h6>
                            <h3 class="mb-0">{{ App\Models\Contact::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count() }}</h3>
                        </div>
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng danh sách -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-list"></i> Danh sách liên hệ
            </h5>
        </div>
        <div class="card-body p-0">
            @if($contacts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th style="width: 30%">Tin nhắn</th>
                                <th>Ngày gửi</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                            <tr>
                                <td><strong>#{{ $contact->id }}</strong></td>
                                <td>{{ $contact->name }}</td>
                                <td>
                                    <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                        <i class="fas fa-envelope"></i> {{ $contact->email }}
                                    </a>
                                </td>
                                <td>
                                    @if($contact->phone)
                                        <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                                            <i class="fas fa-phone"></i> {{ $contact->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                         title="{{ $contact->message }}">
                                        {{ $contact->message }}
                                    </div>
                                </td>
                                <td>
                                    <small>
                                        <i class="far fa-calendar"></i> {{ $contact->created_at->format('d/m/Y') }}<br>
                                        <i class="far fa-clock"></i> {{ $contact->created_at->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewModal{{ $contact->id }}"
                                            title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form action="{{ route('admin.contacts.delete', $contact->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa liên hệ này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal xem chi tiết -->
                            <div class="modal fade" id="viewModal{{ $contact->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Chi tiết liên hệ #{{ $contact->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Tên:</strong><br>
                                                    {{ $contact->name }}
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Email:</strong><br>
                                                    <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Số điện thoại:</strong><br>
                                                    @if($contact->phone)
                                                        <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                                    @else
                                                        <span class="text-muted">Không có</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Ngày gửi:</strong><br>
                                                    {{ $contact->created_at->format('d/m/Y H:i:s') }}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Nội dung tin nhắn:</strong>
                                                <div class="p-3 bg-light rounded mt-2">
                                                    {{ $contact->message }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="mailto:{{ $contact->email }}" class="btn btn-primary">
                                                <i class="fas fa-reply"></i> Trả lời qua Email
                                            </a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            Hiển thị {{ $contacts->firstItem() }} - {{ $contacts->lastItem() }}
                            trong tổng số {{ $contacts->total() }} liên hệ
                        </div>
                        <div>
                            {{ $contacts->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có liên hệ nào</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
