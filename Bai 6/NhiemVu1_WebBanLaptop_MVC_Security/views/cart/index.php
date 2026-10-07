<?php
/**
 * View Cart Index: Quản lý giỏ hàng với AJAX cập nhật số lượng, xóa sản phẩm và tính tổng tiền
 */
?>
<div class="container py-4">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?r=home/index">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng của bạn</li>
        </ol>
    </nav>

    <h3 class="fw-bold mb-4"><i class="fas fa-shopping-cart text-primary me-2"></i>Giỏ Hàng Mua Sắm</h3>

    <?php if (empty($cart)): ?>
        <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center my-4">
            <i class="fas fa-cart-arrow-down fa-4x text-muted mb-3"></i>
            <h4 class="fw-bold">Giỏ hàng của bạn đang trống!</h4>
            <p class="text-secondary">Hãy lướt xem hàng chục mẫu laptop cấu hình cao giá ưu đãi và chọn sản phẩm bạn yêu thích.</p>
            <div class="mt-3">
                <a href="index.php?r=product/index" class="btn btn-primary rounded-pill px-4 py-2">
                    <i class="fas fa-arrow-left me-2"></i> Mua sắm ngay
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <!-- CART ITEMS TABLE -->
            <div class="col-lg-8">
                <div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 45%;">Sản phẩm</th>
                                    <th style="width: 20%;">Đơn giá</th>
                                    <th style="width: 15%;">Số lượng</th>
                                    <th style="width: 15%;">Thành tiền</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="uploads/<?= Security::escape($item['image']) ?>" onerror="this.src='assets/images/dell_vostro.jpg'" alt="<?= Security::escape($item['name']) ?>" width="60" height="60" class="rounded object-fit-contain bg-light p-1">
                                                <div>
                                                    <a href="index.php?r=product/detail&id=<?= $item['id'] ?>" class="fw-bold text-dark text-decoration-none small">
                                                        <?= Security::escape($item['name']) ?>
                                                    </a>
                                                    <div><span class="badge bg-light text-primary border" style="font-size: 10px;"><?= Security::escape($item['brand']) ?></span></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="small fw-semibold"><?= number_format($item['price'], 0, ',', '.') ?> đ</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm cart-qty-input text-center" style="width: 70px;" value="<?= (int)$item['quantity'] ?>" min="1" max="99" data-id="<?= $item['id'] ?>">
                                        </td>
                                        <td class="text-danger fw-bold small item-subtotal">
                                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ
                                        </td>
                                        <td class="text-end">
                                            <a href="index.php?r=cart/remove&id=<?= $item['id'] ?>" class="btn btn-sm btn-link text-danger p-0" title="Xóa món này" onclick="return confirm('Bạn có chắc muốn xóa món này khỏi giỏ?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="index.php?r=product/index" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Tiếp tục mua sản phẩm khác
                    </a>
                    <a href="index.php?r=cart/clear" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');">
                        <i class="fas fa-trash me-1"></i> Xóa sạch giỏ hàng
                    </a>
                </div>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="col-lg-4">
                <div class="card border rounded-4 bg-white p-4 shadow-sm sticky-top" style="top: 90px;">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Tóm Tắt Đơn Hàng</h5>

                    <div class="d-flex justify-content-between mb-2 small text-secondary">
                        <span>Tạm tính hàng hóa:</span>
                        <span class="fw-bold text-dark" id="cartTotalAmount"><?= number_format($totalAmount, 0, ',', '.') ?> đ</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 small text-secondary">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success fw-bold">MIỄN PHÍ TOÀN QUỐC</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 small text-secondary">
                        <span>Bảo hiểm vận chuyển:</span>
                        <span class="text-success fw-bold">ĐÃ BAO GỒM</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <span class="fw-bold fs-6">Tổng thanh toán:</span>
                        <span class="text-danger fw-extrabold fs-4"><?= number_format($totalAmount, 0, ',', '.') ?> đ</span>
                    </div>

                    <a href="index.php?r=cart/checkout" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> Tiến Hành Đặt Hàng
                    </a>

                    <div class="mt-3 text-center small text-muted">
                        <i class="fas fa-lock me-1"></i> Giao dịch bảo mật chuẩn SSL / CSRF Guard
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>
