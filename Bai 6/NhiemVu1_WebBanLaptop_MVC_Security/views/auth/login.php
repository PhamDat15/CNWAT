<?php
/**
 * View Auth Login: Đăng nhập có bảo vệ Brute Force, CSRF và lưu session an toàn
 */
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="bg-primary text-white d-inline-flex p-3 rounded-circle mb-3 shadow-sm">
                        <i class="fas fa-user-lock fa-2x"></i>
                    </div>
                    <h3 class="fw-bold">Đăng Nhập Tài Khoản</h3>
                    <p class="text-secondary small">Truy cập để quản lý đơn hàng hoặc trang quản trị viên</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger small shadow-sm d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                        <div><?= Security::escape($error) ?></div>
                    </div>
                <?php endif; ?>

                <form action="index.php?r=auth/login" method="POST">
                    <?= Security::getCsrfField() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Tên đăng nhập hoặc Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="fas fa-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="admin hoặc customer..." required autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="fas fa-key"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu của bạn..." required autocomplete="current-password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm mb-3">
                        <i class="fas fa-sign-in-alt me-1"></i> Đăng Nhập
                    </button>
                </form>

                <!-- DEMO ACCOUNTS HELPER -->
                <div class="p-3 bg-light rounded-3 small border mb-3">
                    <div class="fw-bold text-dark mb-1"><i class="fas fa-info-circle text-info me-1"></i> Tài khoản mẫu kiểm thử:</div>
                    <div class="d-flex justify-content-between text-secondary">
                        <span>Quản trị (Admin):</span>
                        <code>admin</code> / <code>123456</code>
                    </div>
                    <div class="d-flex justify-content-between text-secondary mt-1">
                        <span>Khách hàng (User):</span>
                        <code>customer</code> / <code>123456</code>
                    </div>
                </div>

                <div class="text-center small text-secondary">
                    Chưa có tài khoản? <a href="index.php?r=auth/register" class="text-primary fw-semibold text-decoration-none">Đăng ký ngay tại đây</a>
                </div>
            </div>
        </div>
    </div>
</div>
