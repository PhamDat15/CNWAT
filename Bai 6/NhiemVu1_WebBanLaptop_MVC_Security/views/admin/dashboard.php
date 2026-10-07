<?php
/**
 * View Admin Dashboard: Tổng quan hệ thống E-commerce Laptop
 */
?>
<div class="row g-4 mb-4">
    <!-- STAT CARD 1: PRODUCTS -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Kho Laptop</span>
                <div class="bg-primary-subtle text-primary p-2 rounded-3"><i class="fas fa-laptop fa-lg"></i></div>
            </div>
            <h3 class="fw-bold mb-0 text-dark"><?= (int)$stats['total_products'] ?></h3>
            <small class="text-success"><i class="fas fa-check-circle me-1"></i>Sản phẩm đang bán</small>
        </div>
    </div>

    <!-- STAT CARD 2: USERS -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Người Dùng</span>
                <div class="bg-info-subtle text-info p-2 rounded-3"><i class="fas fa-users fa-lg"></i></div>
            </div>
            <h3 class="fw-bold mb-0 text-dark"><?= (int)$stats['total_users'] ?></h3>
            <small class="text-primary"><i class="fas fa-user-shield me-1"></i>RBAC Bảo mật</small>
        </div>
    </div>

    <!-- STAT CARD 3: ORDERS -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Đơn Hàng</span>
                <div class="bg-warning-subtle text-warning p-2 rounded-3"><i class="fas fa-shopping-bag fa-lg"></i></div>
            </div>
            <h3 class="fw-bold mb-0 text-dark"><?= (int)$stats['total_orders'] ?></h3>
            <small class="text-secondary"><i class="fas fa-clock me-1"></i>Tổng đơn đã tạo</small>
        </div>
    </div>

    <!-- STAT CARD 4: REVENUE -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-bold text-uppercase">Doanh Thu</span>
                <div class="bg-success-subtle text-success p-2 rounded-3"><i class="fas fa-coins fa-lg"></i></div>
            </div>
            <h4 class="fw-extrabold mb-0 text-success"><?= number_format($stats['total_revenue'], 0, ',', '.') ?> đ</h4>
            <small class="text-success"><i class="fas fa-arrow-up me-1"></i>Đơn hàng hợp lệ</small>
        </div>
    </div>
</div>

<!-- RECENT ORDERS & RECENT PRODUCTS -->
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="fas fa-receipt text-primary me-2"></i>Đơn Hàng Mới Nhất</h5>
                <a href="index.php?r=admin/orders" class="small text-primary text-decoration-none">Xem tất cả &rarr;</a>
            </div>

            <?php if (empty($recentOrders)): ?>
                <p class="text-muted small py-4 text-center">Chưa có đơn hàng nào.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle small mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $ord): ?>
                                <tr>
                                    <td><strong>#<?= $ord['id'] ?></strong></td>
                                    <td>
                                        <div class="fw-semibold"><?= Security::escape($ord['customer_name']) ?></div>
                                        <div class="text-muted" style="font-size: 11px;"><?= Security::escape($ord['customer_phone']) ?></div>
                                    </td>
                                    <td class="text-danger fw-bold"><?= number_format($ord['total_amount'], 0, ',', '.') ?> đ</td>
                                    <td>
                                        <span class="badge bg-warning text-dark"><?= Security::escape($ord['status']) ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="fas fa-laptop text-primary me-2"></i>Sản Phẩm Vừa Cập Nhật</h5>
                <a href="index.php?r=admin/products" class="small text-primary text-decoration-none">Quản lý &rarr;</a>
            </div>

            <div class="list-group list-group-flush">
                <?php foreach ($recentProducts as $prod): ?>
                    <div class="list-group-item px-0 py-2 d-flex align-items-center gap-3">
                        <img src="uploads/<?= Security::escape($prod['image']) ?>" onerror="this.src='assets/images/dell_vostro.jpg'" width="42" height="42" class="rounded object-fit-contain bg-light p-1">
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="small fw-bold text-truncate"><?= Security::escape($prod['name']) ?></div>
                            <span class="badge bg-light text-primary border" style="font-size: 10px;"><?= Security::escape($prod['brand']) ?></span>
                        </div>
                        <div class="small fw-bold text-danger">
                            <?= number_format($prod['price'], 0, ',', '.') ?> đ
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
