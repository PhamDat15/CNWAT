<?php
/**
 * View Admin Users: Quản lý người dùng và phân quyền RBAC
 */
?>
<div class="card border-0 rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fas fa-users-cog text-primary me-2"></i>Quản Lý Người Dùng &amp; Phân Quyền (RBAC)</h4>
            <p class="text-secondary small mb-0">Quản trị danh sách tài khoản, vai trò truy cập (Admin / Customer) và tính an toàn hệ thống</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Vai trò (Role)</th>
                    <th>Ngày tạo</th>
                    <th class="text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><strong>#<?= $u['id'] ?></strong></td>
                        <td><code><?= Security::escape($u['username']) ?></code></td>
                        <td class="fw-semibold"><?= Security::escape($u['fullname']) ?></td>
                        <td><?= Security::escape($u['email']) ?></td>
                        <td>
                            <?php if ($u['role'] === 'admin'): ?>
                                <span class="badge bg-danger"><i class="fas fa-shield-alt me-1"></i>ADMINISTRATOR</span>
                            <?php else: ?>
                                <span class="badge bg-primary"><i class="fas fa-user me-1"></i>CUSTOMER</span>
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted"><?= Security::escape($u['created_at'] ?? 'N/A') ?></td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="index.php?r=admin/userEdit&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-primary" title="Sửa quyền">
                                    <i class="fas fa-edit"></i> Phân quyền
                                </a>
                                <?php if ($u['id'] != Security::getUser()['id']): ?>
                                    <form action="index.php?r=admin/userDelete" method="POST" class="d-inline">
                                        <?= Security::getCsrfField() ?>
                                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-confirm" title="Xóa tài khoản">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
