<?php
/**
 * View Admin Orders: Quản lý danh sách và trạng thái đơn hàng
 */
?>
<div class="card border-0 rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fas fa-receipt text-primary me-2"></i>Quản Lý Đơn Hàng Khách Hàng</h4>
            <p class="text-secondary small mb-0">Theo dõi thông tin thanh toán, địa chỉ người nhận và cập nhật trạng thái đơn</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Địa chỉ nhận hàng</th>
                    <th>Tổng tiền</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Cập nhật</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Chưa có đơn hàng nào trong hệ thống.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><strong>#<?= $o['id'] ?></strong></td>
                            <td>
                                <div class="fw-bold"><?= Security::escape($o['customer_name']) ?></div>
                                <div class="text-muted small"><i class="fas fa-phone me-1"></i><?= Security::escape($o['customer_phone']) ?></div>
                            </td>
                            <td>
                                <div class="small text-truncate" style="max-width: 250px;" title="<?= Security::escape($o['customer_address']) ?>">
                                    <?= Security::escape($o['customer_address']) ?>
                                </div>
                                <?php if (!empty($o['customer_notes'])): ?>
                                    <small class="text-info d-block fst-italic">Note: <?= Security::escape($o['customer_notes']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="text-danger fw-bold"><?= number_format($o['total_amount'], 0, ',', '.') ?> đ</span>
                            </td>
                            <td class="small text-muted"><?= Security::escape($o['created_at']) ?></td>
                            <td>
                                <?php
                                $statusBadge = [
                                    'pending' => '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Chờ xử lý</span>',
                                    'processing' => '<span class="badge bg-info text-dark"><i class="fas fa-spinner fa-spin me-1"></i>Đang đóng gói</span>',
                                    'completed' => '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Đã giao hàng</span>',
                                    'cancelled' => '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Đã hủy</span>'
                                ];
                                echo $statusBadge[$o['status']] ?? $o['status'];
                                ?>
                            </td>
                            <td class="text-end">
                                <form action="index.php?r=admin/orderStatus" method="POST" class="d-inline-flex gap-1 align-items-center">
                                    <?= Security::getCsrfField() ?>
                                    <input type="hidden" name="id" value="<?= $o['id'] ?>">
                                    <select name="status" class="form-select form-select-sm" style="width: 140px;">
                                        <option value="pending" <?= ($o['status'] === 'pending') ? 'selected' : '' ?>>Chờ xử lý</option>
                                        <option value="processing" <?= ($o['status'] === 'processing') ? 'selected' : '' ?>>Đang xử lý</option>
                                        <option value="completed" <?= ($o['status'] === 'completed') ? 'selected' : '' ?>>Đã hoàn tất</option>
                                        <option value="cancelled" <?= ($o['status'] === 'cancelled') ? 'selected' : '' ?>>Hủy đơn</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Lưu
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
