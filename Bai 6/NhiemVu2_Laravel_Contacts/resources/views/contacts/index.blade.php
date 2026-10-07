@extends('layouts.app')

@section('title', 'Danh Sách Danh Bạ - Contacts Management')

@section('content')
<div class="mb-4">
    <!-- FLASH ALERTS -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- STATS CHIPS & SEARCH BAR -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <div class="row g-3 align-items-center justify-content-between mb-3">
            <div class="col-md-5">
                <h4 class="fw-bold mb-1"><i class="fas fa-address-book text-primary me-2"></i>Danh Bạ Liên Hệ</h4>
                <p class="text-secondary small mb-0">Tổng cộng có <strong>{{ $totalContacts ?? count($contacts) }}</strong> liên hệ được lưu trữ an toàn</p>
            </div>
            <div class="col-md-7">
                <form action="index.php" method="GET" class="d-flex gap-2">
                    <input type="hidden" name="r" value="contacts/index">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Tìm theo tên, số điện thoại hoặc email..." value="{{ $search ?? '' }}">
                    </div>
                    @if(!empty($category))
                        <input type="hidden" name="category" value="{{ $category }}">
                    @endif
                    <button type="submit" class="btn btn-primary px-3" style="background-color: var(--primary-color);">Tìm</button>
                    @if(!empty($search) || !empty($category))
                        <a href="index.php" class="btn btn-outline-secondary">Xóa lọc</a>
                    @endif
                </form>
            </div>
        </div>

        <!-- CATEGORY PILLS -->
        <div class="d-flex flex-wrap gap-2 pt-2 border-top">
            <span class="small text-muted align-self-center me-2">Phân loại:</span>
            <a href="index.php?r=contacts/index&search={{ urlencode($search ?? '') }}" class="btn btn-sm rounded-pill {{ empty($category) ? 'btn-primary' : 'btn-light border' }}">
                Tất cả
            </a>
            @foreach(['Gia đình', 'Bạn bè', 'Công việc', 'Khách hàng', 'Đối tác', 'Khác'] as $cat)
                <a href="index.php?r=contacts/index&category={{ urlencode($cat) }}&search={{ urlencode($search ?? '') }}" class="btn btn-sm rounded-pill {{ ($category ?? '') === $cat ? 'btn-primary' : 'btn-light border' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- CONTACT CARDS GRID -->
    @if(empty($contacts))
        <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center">
            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
            <h5>Chưa tìm thấy liên hệ nào phù hợp!</h5>
            <p class="text-secondary small">Bạn có thể tạo mới liên hệ hoặc thử tìm kiếm với từ khóa khác.</p>
            <div class="mt-2">
                <a href="index.php?r=contacts/create" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-plus me-1"></i> Thêm Liên Hệ Mới
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($contacts as $c)
                @php
                    $safeCatClass = 'badge-cat-' . str_replace(' ', '-', $c['category']);
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="contact-card p-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            @if(!empty($c['avatar']))
                                <img src="public/uploads/{{ $c['avatar'] }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($c['name']) }}&background=4f46e5&color=fff&size=64'" class="contact-avatar" alt="{{ $c['name'] }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($c['name']) }}&background=4f46e5&color=fff&size=64" class="contact-avatar" alt="{{ $c['name'] }}">
                            @endif
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="fw-bold text-dark mb-1 text-truncate" title="{{ $c['name'] }}">
                                    <a href="index.php?r=contacts/show&id={{ $c['id'] }}" class="text-dark text-decoration-none">
                                        {{ $c['name'] }}
                                    </a>
                                </h5>
                                <span class="badge {{ $safeCatClass }} rounded-pill px-3 py-1 font-monospace small">
                                    {{ $c['category'] }}
                                </span>
                            </div>
                        </div>

                        <div class="small text-secondary mb-3 flex-grow-1">
                            <div class="mb-1 text-truncate">
                                <i class="fas fa-phone-alt text-primary fa-fw me-2"></i>
                                <a href="tel:{{ $c['phone'] }}" class="text-dark text-decoration-none fw-semibold">{{ $c['phone'] }}</a>
                            </div>
                            @if(!empty($c['email']))
                                <div class="mb-1 text-truncate">
                                    <i class="fas fa-envelope text-info fa-fw me-2"></i>
                                    <a href="mailto:{{ $c['email'] }}" class="text-secondary text-decoration-none">{{ $c['email'] }}</a>
                                </div>
                            @endif
                            @if(!empty($c['birthdate']))
                                <div class="mb-1 text-truncate">
                                    <i class="fas fa-birthday-cake text-warning fa-fw me-2"></i>
                                    <span>{{ date('d/m/Y', strtotime($c['birthdate'])) }}</span>
                                </div>
                            @endif
                            @if(!empty($c['address']))
                                <div class="text-truncate" title="{{ $c['address'] }}">
                                    <i class="fas fa-map-marker-alt text-danger fa-fw me-2"></i>
                                    <span>{{ $c['address'] }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- ACTIONS -->
                        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <a href="tel:{{ $c['phone'] }}" class="btn btn-sm btn-outline-success rounded-circle" title="Gọi điện">
                                    <i class="fas fa-phone"></i>
                                </a>
                                @if(!empty($c['email']))
                                    <a href="mailto:{{ $c['email'] }}" class="btn btn-sm btn-outline-info rounded-circle" title="Gửi email">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="index.php?r=contacts/show&id={{ $c['id'] }}" class="btn btn-sm btn-outline-secondary" title="Chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?r=contacts/edit&id={{ $c['id'] }}" class="btn btn-sm btn-outline-primary" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="index.php?r=contacts/destroy" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $c['id'] }}">
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-contact" title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
