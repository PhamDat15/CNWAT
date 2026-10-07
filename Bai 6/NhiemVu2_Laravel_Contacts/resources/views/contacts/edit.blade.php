@extends('layouts.app')

@section('title', 'Chỉnh Sửa Liên Hệ - Contacts Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <div>
                    <h4 class="fw-bold mb-1"><i class="fas fa-user-edit text-primary me-2"></i>Chỉnh Sửa Liên Hệ</h4>
                    <p class="text-secondary small mb-0">Cập nhật thông tin cho liên hệ: <strong>{{ $contact['name'] }}</strong></p>
                </div>
                <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
            </div>

            @if(!empty($errors))
                <div class="alert alert-danger small shadow-sm">
                    <ul class="mb-0 ps-3">
                        @foreach($errors as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="index.php?r=contacts/update&id={{ $contact['id'] }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- HỌ VÀ TÊN -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $contact['name'] }}" required>
                    </div>

                    <!-- SỐ ĐIỆN THOẠI -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control" value="{{ $contact['phone'] }}" required>
                    </div>

                    <!-- EMAIL -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Địa chỉ Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $contact['email'] ?? '' }}">
                    </div>

                    <!-- NHÓM LIÊN HỆ -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Phân loại nhóm <span class="text-danger">*</span></label>
                        <select name="category" class="form-select" required>
                            @foreach(['Bạn bè', 'Gia đình', 'Công việc', 'Khách hàng', 'Đối tác', 'Khác'] as $cat)
                                <option value="{{ $cat }}" {{ $contact['category'] === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- NGÀY SINH -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">
                            <i class="fas fa-calendar-alt text-primary me-1"></i> Ngày sinh (Datetime Picker)
                        </label>
                        <input type="text" id="birthdatePicker" name="birthdate" class="form-control" value="{{ $contact['birthdate'] ?? '' }}">
                    </div>

                    <!-- ẢNH ĐẠI DIỆN -->
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">
                            <i class="fas fa-image text-primary me-1"></i> Đổi ảnh đại diện (Tùy chọn)
                        </label>
                        <input type="file" name="avatar" class="form-control" accept="image/jpeg,image/png,image/webp">
                        @if(!empty($contact['avatar']))
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <small class="text-secondary">Ảnh hiện tại:</small>
                                <img src="public/uploads/{{ $contact['avatar'] }}" width="36" height="36" class="rounded-circle border" alt="Avatar">
                            </div>
                        @endif
                    </div>

                    <!-- ĐỊA CHỈ -->
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Địa chỉ liên hệ</label>
                        <input type="text" name="address" class="form-control" value="{{ $contact['address'] ?? '' }}">
                    </div>

                    <!-- GHI CHÚ -->
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Ghi chú thêm</label>
                        <textarea name="notes" rows="3" class="form-control">{{ $contact['notes'] ?? '' }}</textarea>
                    </div>

                    <!-- BUTTONS -->
                    <div class="col-12 pt-3 border-top d-flex gap-2">
                        <a href="index.php" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm" style="background-color: var(--primary-color);">
                            <i class="fas fa-save me-1"></i> Lưu Cập Nhật
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#birthdatePicker", {
        dateFormat: "Y-m-d",
        locale: "vn",
        maxDate: "today"
    });
});
</script>
@endsection
