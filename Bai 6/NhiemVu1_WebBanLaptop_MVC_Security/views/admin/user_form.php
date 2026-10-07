<?php
/**
 * View Admin User Form: Chỉnh sửa thông tin và phân quyền người dùng
 */
?>
<div class="card border-0 rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="fas fa-user-edit text-primary me-2"></i>Chỉnh Sửa Quyền &amp; Tài Khoản</h4>
            <p class="text-secondary small mb-0">Tài khoản: <code><?= Security::escape($user['username']) ?></code></p>
        </div>
        <a href="index.php?r=admin/users" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <form action="index.php?r=admin/userEdit&id=<?= $user['id'] ?>" method="POST" style="max-width: 600px;">
        <?= Security::getCsrfField() ?>

        <div class="mb-3">
            <label class="form-label small fw-semibold">Tên đăng nhập</label>
            <input type="text" class="form-control" value="<?= Security::escape($user['username']) ?>" disabled>
            <small class="text-muted" style="font-size: 11px;">Tên đăng nhập là khóa định danh duy nhất không được phép thay đổi</small>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold">Họ và tên</label>
            <input type="text" name="fullname" class="form-control" value="<?= Security::escape($user['fullname']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold">Địa chỉ Email</label>
            <input type="email" name="email" class="form-control" value="<?= Security::escape($user['email']) ?>" required>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-semibold">Phân quyền vai trò (Role)</label>
            <select name="role" class="form-select">
                <option value="customer" <?= ($user['role'] === 'customer') ? 'selected' : '' ?>>Khách hàng (Customer - Chỉ xem và đặt hàng)</option>
                <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Quản trị viên (Admin - Toàn quyền truy cập Dashboard)</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <a href="index.php?r=admin/users" class="btn btn-outline-secondary">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-1"></i> Lưu Quyền Hạn
            </button>
        </div>
    </form>
</div>
