<?php
/**
 * View Auth Register: Đăng ký tài khoản mới với kiểm tra ràng buộc mật khẩu và mã hóa Bcrypt
 */
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="bg-success text-white d-inline-flex p-3 rounded-circle mb-3 shadow-sm">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                    <h3 class="fw-bold">Đăng Ký Tài Khoản</h3>
                    <p class="text-secondary small">Trở thành thành viên để nhận hàng ngàn ưu đãi laptop công nghệ</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger small shadow-sm">
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $err): ?>
                                <li><?= Security::escape($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="index.php?r=auth/register" method="POST">
                    <?= Security::getCsrfField() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Tên đăng nhập (Username) <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" placeholder="Từ 3-30 ký tự không dấu (ví dụ: nguyenvana)" value="<?= Security::escape($formData['username'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Họ và tên đầy đủ <span class="text-danger">*</span></label>
                        <input type="text" name="fullname" class="form-control" placeholder="Ví dụ: Nguyễn Văn A" value="<?= Security::escape($formData['fullname'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Địa chỉ Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" value="<?= Security::escape($formData['email'] ?? '') ?>" required>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự" required autocomplete="new-password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirm" class="form-control" placeholder="Khớp mật khẩu" required autocomplete="new-password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill shadow-sm mb-3">
                        <i class="fas fa-check-circle me-1"></i> Hoàn Tất Đăng Ký
                    </button>
                </form>

                <div class="text-center small text-secondary">
                    Đã có tài khoản? <a href="index.php?r=auth/login" class="text-primary fw-semibold text-decoration-none">Đăng nhập tại đây</a>
                </div>
            </div>
        </div>
    </div>
</div>
