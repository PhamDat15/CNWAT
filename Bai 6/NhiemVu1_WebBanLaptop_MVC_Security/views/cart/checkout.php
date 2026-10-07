<?php
/**
 * View Cart Checkout: Thanh toán và tạo đơn hàng có bảo vệ CSRF
 */
?>
<div class="container py-4">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?r=home/index">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="index.php?r=cart/index">Giỏ hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thanh toán đơn hàng</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- FORM GIAO HÀNG -->
        <div class="col-lg-7">
            <div class="card border rounded-4 bg-white p-4 shadow-sm">
                <h4 class="fw-bold mb-3 border-bottom pb-2">
                    <i class="fas fa-shipping-fast text-primary me-2"></i>Thông Tin Giao Hàng &amp; Thanh Toán
                </h4>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger small shadow-sm">
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $err): ?>
                                <li><?= Security::escape($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="index.php?r=cart/checkout" method="POST">
                    <?= Security::getCsrfField() ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Họ và tên người nhận <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Ví dụ: Nguyễn Văn A" value="<?= Security::escape($formData['name'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Số điện thoại liên hệ <span class="text-danger">*</span></label>
                        <input type="tel" name="customer_phone" class="form-control" placeholder="Ví dụ: 0912345678" value="<?= Security::escape($formData['phone'] ?? '') ?>" required>
                        <small class="text-muted" style="font-size: 11px;">Được dùng để shipper gọi khi nhận máy</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Địa chỉ nhận hàng chi tiết <span class="text-danger">*</span></label>
                        <textarea name="customer_address" rows="3" class="form-control" placeholder="Số nhà, ngõ/ngách, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..." required><?= Security::escape($formData['address'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Ghi chú thêm cho đơn hàng (Tùy chọn)</label>
                        <textarea name="customer_notes" rows="2" class="form-control" placeholder="Ví dụ: Giao giờ hành chính, cài sẵn Windows 11 bản quyền..."><?= Security::escape($formData['notes'] ?? '') ?></textarea>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 border">
                        <h6 class="fw-bold mb-2"><i class="fas fa-wallet text-success me-2"></i>Phương thức thanh toán:</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payCod" value="cod" checked>
                            <label class="form-check-label small" for="payCod">
                                <strong>Thanh toán khi nhận hàng (COD)</strong> - Kiểm tra máy trước khi thanh toán
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="index.php?r=cart/index" class="btn btn-outline-secondary px-3">Quay lại giỏ hàng</a>
                        <button type="submit" class="btn btn-primary px-4 flex-grow-1">
                            <i class="fas fa-check-circle me-1"></i> Xác Nhận Đặt Mua Ngay
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ORDER PREVIEW -->
        <div class="col-lg-5">
            <div class="card border rounded-4 bg-white p-4 shadow-sm sticky-top" style="top: 90px;">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Đơn Hàng (<?= count($cart) ?> món)</h5>

                <div class="mb-3" style="max-height: 280px; overflow-y: auto;">
                    <?php foreach ($cart as $item): ?>
                        <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                            <img src="uploads/<?= Security::escape($item['image']) ?>" onerror="this.src='assets/images/dell_vostro.jpg'" width="48" height="48" class="rounded object-fit-contain bg-light p-1">
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="small fw-bold text-truncate"><?= Security::escape($item['name']) ?></div>
                                <div class="small text-muted">SL: <?= (int)$item['quantity'] ?> x <?= number_format($item['price'], 0, ',', '.') ?> đ</div>
                            </div>
                            <div class="small fw-bold text-danger">
                                <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-between mb-2 small text-secondary">
                    <span>Tạm tính:</span>
                    <span><?= number_format($totalAmount, 0, ',', '.') ?> đ</span>
                </div>
                <div class="d-flex justify-content-between mb-3 small text-secondary">
                    <span>Vận chuyển:</span>
                    <span class="text-success fw-bold">MIỄN PHÍ</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <span class="fw-bold">Tổng thanh toán:</span>
                    <span class="text-danger fw-extrabold fs-4"><?= number_format($totalAmount, 0, ',', '.') ?> đ</span>
                </div>

                <div class="small text-muted mt-3">
                    <i class="fas fa-shield-alt text-success me-1"></i> Thông tin đặt hàng của bạn được bảo mật tuyệt đối với thuật toán băm và bộ lọc kiểm duyệt dữ liệu.
                </div>
            </div>
        </div>
    </div>

</div>
