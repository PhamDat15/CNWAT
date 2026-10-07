<?php
/**
 * View Auth Profile: Hồ sơ cá nhân người dùng
 */
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['fullname']) ?>&background=2563eb&color=fff&size=64" class="rounded-circle shadow-sm" alt="Avatar">
                    <div>
                        <h4 class="fw-bold mb-0"><?= Security::escape($user['fullname']) ?></h4>
                        <div class="text-secondary small">Tài khoản: <code><?= Security::escape($user['username']) ?></code></div>
                        <span class="badge <?= ($user['role'] === 'admin') ? 'bg-danger' : 'bg-primary' ?> mt-1">
                            <?= strtoupper($user['role']) ?>
                        </span>
                    </div>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success small shadow-sm"><?= Security::escape($message) ?></div>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger small shadow-sm"><?= Security::escape($error) ?></div>
                <?php endif; ?>

                <form action="index.php?r=auth/profile" method="POST">
                    <?= Security::getCsrfField() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Họ và tên</label>
                        <input type="text" name="fullname" class="form-control" value="<?= Security::escape($user['fullname']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Địa chỉ Email</label>
                        <input type="email" name="email" class="form-control" value="<?= Security::escape($user['email']) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Đổi mật khẩu mới (Bỏ trống nếu không đổi)</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Nhập mật khẩu mới từ 6 ký tự...">
                    </div>

                    <div class="d-flex gap-2">
                        <a href="index.php?r=home/index" class="btn btn-outline-secondary">Về trang chủ</a>
                        <button type="submit" class="btn btn-primary px-4 flex-grow-1">
                            <i class="fas fa-save me-1"></i> Lưu Thay Đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
