@extends('layouts.app')

@section('title', $contact['name'] . ' - Chi Tiết Danh Bạ')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i> Danh sách danh bạ
                </a>
                <div class="d-flex gap-2">
                    <a href="index.php?r=contacts/edit&id={{ $contact['id'] }}" class="btn btn-primary btn-sm rounded-pill px-3" style="background-color: var(--primary-color);">
                        <i class="fas fa-edit me-1"></i> Chỉnh sửa
                    </a>
                    <form action="index.php?r=contacts/destroy" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="id" value="{{ $contact['id'] }}">
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 btn-delete-contact">
                            <i class="fas fa-trash-alt me-1"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>

            <!-- PROFILE HEADER -->
            <div class="text-center mb-4">
                @if(!empty($contact['avatar']))
                    <img src="public/uploads/{{ $contact['avatar'] }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($contact['name']) }}&background=4f46e5&color=fff&size=100'" class="rounded-circle shadow border border-3 border-indigo mb-3" width="100" height="100" alt="Avatar">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($contact['name']) }}&background=4f46e5&color=fff&size=100" class="rounded-circle shadow border border-3 border-indigo mb-3" width="100" height="100" alt="Avatar">
                @endif

                <h3 class="fw-bold mb-1">{{ $contact['name'] }}</h3>
                <div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 font-monospace">
                        {{ $contact['category'] }}
                    </span>
                </div>

                <!-- QUICK ACTIONS -->
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="tel:{{ $contact['phone'] }}" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-phone-alt me-2"></i> Gọi điện
                    </a>
                    @if(!empty($contact['email']))
                        <a href="mailto:{{ $contact['email'] }}" class="btn btn-info text-white rounded-pill px-4">
                            <i class="fas fa-envelope me-2"></i> Gửi email
                        </a>
                    @endif
                </div>
            </div>

            <!-- DETAILS LIST -->
            <div class="list-group list-group-flush border rounded-3 mb-4">
                <div class="list-group-item p-3 d-flex align-items-center">
                    <div class="text-primary me-3 fs-5"><i class="fas fa-phone-alt fa-fw"></i></div>
                    <div>
                        <div class="small text-muted">Số điện thoại</div>
                        <div class="fw-bold">{{ $contact['phone'] }}</div>
                    </div>
                </div>

                @if(!empty($contact['email']))
                    <div class="list-group-item p-3 d-flex align-items-center">
                        <div class="text-info me-3 fs-5"><i class="fas fa-envelope fa-fw"></i></div>
                        <div>
                            <div class="small text-muted">Hòm thư điện tử (Email)</div>
                            <div class="fw-bold">{{ $contact['email'] }}</div>
                        </div>
                    </div>
                @endif

                @if(!empty($contact['birthdate']))
                    <div class="list-group-item p-3 d-flex align-items-center">
                        <div class="text-warning me-3 fs-5"><i class="fas fa-birthday-cake fa-fw"></i></div>
                        <div>
                            <div class="small text-muted">Ngày sinh</div>
                            <div class="fw-bold">{{ date('d/m/Y', strtotime($contact['birthdate'])) }}</div>
                        </div>
                    </div>
                @endif

                @if(!empty($contact['address']))
                    <div class="list-group-item p-3 d-flex align-items-center">
                        <div class="text-danger me-3 fs-5"><i class="fas fa-map-marker-alt fa-fw"></i></div>
                        <div>
                            <div class="small text-muted">Địa chỉ liên lạc</div>
                            <div class="fw-bold">{{ $contact['address'] }}</div>
                        </div>
                    </div>
                @endif

                @if(!empty($contact['notes']))
                    <div class="list-group-item p-3 d-flex align-items-start">
                        <div class="text-secondary me-3 fs-5 mt-1"><i class="fas fa-sticky-note fa-fw"></i></div>
                        <div>
                            <div class="small text-muted">Ghi chú cá nhân</div>
                            <div class="text-secondary">{{ $contact['notes'] }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-center small text-muted">
                Đã thêm vào danh bạ lúc: {{ $contact['created_at'] ?? 'N/A' }}
            </div>
        </div>
    </div>
</div>
@endsection
