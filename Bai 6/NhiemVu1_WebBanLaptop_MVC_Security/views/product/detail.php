<?php
/**
 * View Product Detail: Chi tiết laptop, thông số kỹ thuật, mô tả Rich Text và sản phẩm liên quan
 */
?>
<div class="container py-4">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?r=home/index">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="index.php?r=product/index">Laptop</a></li>
            <li class="breadcrumb-item"><a href="index.php?r=product/index&brand=<?= urlencode($product['brand']) ?>"><?= Security::escape($product['brand']) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= Security::escape($product['name']) ?></li>
        </ol>
    </nav>

    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <div class="row g-4 align-items-center">
            <!-- PRODUCT IMAGE -->
            <div class="col-lg-5 text-center">
                <div class="p-4 bg-light rounded-4 d-flex align-items-center justify-content-center" style="min-height: 350px;">
                    <img src="uploads/<?= Security::escape($product['image']) ?>" onerror="this.src='assets/images/dell_vostro.jpg'" alt="<?= Security::escape($product['name']) ?>" class="img-fluid" style="max-height: 300px; object-fit: contain;">
                </div>
            </div>

            <!-- PRODUCT INFO & ACTIONS -->
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary px-3 py-2 rounded-pill"><?= Security::escape($product['brand']) ?></span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                        <i class="fas fa-check-circle me-1"></i> Còn hàng (<?= (int)$product['quantity'] ?> chiếc)
                    </span>
                </div>

                <h2 class="fw-bold mb-3"><?= Security::escape($product['name']) ?></h2>

                <p class="text-secondary mb-3"><?= Security::escape($product['short_desc'] ?? '') ?></p>

                <!-- PRICE BOX -->
                <div class="p-3 bg-light rounded-3 mb-4 d-flex align-items-baseline gap-3">
                    <span class="fs-2 fw-extrabold text-danger"><?= number_format($product['price'], 0, ',', '.') ?> đ</span>
                    <?php if (!empty($product['old_price'])): ?>
                        <span class="text-decoration-line-through text-muted fs-5"><?= number_format($product['old_price'], 0, ',', '.') ?> đ</span>
                        <span class="badge bg-danger">
                            Tiết kiệm <?= number_format($product['old_price'] - $product['price'], 0, ',', '.') ?> đ
                        </span>
                    <?php endif; ?>
                </div>

                <!-- ADD TO CART -->
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width: 120px;">
                        <label class="form-label small fw-bold mb-1">Số lượng:</label>
                        <input type="number" id="productQty" class="form-control" value="1" min="1" max="<?= (int)$product['quantity'] ?>">
                    </div>
                    <div class="flex-grow-1 align-self-end">
                        <button class="btn btn-primary btn-lg w-100 rounded-3 shadow-sm btn-add-cart-ajax" data-id="<?= $product['id'] ?>">
                            <i class="fas fa-shopping-cart me-2"></i> Thêm Vào Giỏ Hàng
                        </button>
                    </div>
                </div>

                <!-- COMMITMENTS -->
                <div class="row g-2 text-secondary small border-top pt-3">
                    <div class="col-6"><i class="fas fa-truck text-primary me-2"></i>Miễn phí giao hàng toàn quốc</div>
                    <div class="col-6"><i class="fas fa-shield-alt text-success me-2"></i>Bảo hành chính hãng 12-24 tháng</div>
                    <div class="col-6"><i class="fas fa-undo text-warning me-2"></i>Lỗi 1 đổi 1 trong 30 ngày</div>
                    <div class="col-6"><i class="fas fa-headset text-info me-2"></i>Hỗ trợ kỹ thuật 24/7</div>
                </div>
            </div>
        </div>
    </div>

    <!-- SPECS & DESCRIPTION TABS -->
    <div class="row g-4 mb-5">
        <!-- SPECS TABLE -->
        <div class="col-lg-5">
            <div class="card border rounded-4 bg-white p-4 shadow-sm h-100">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="fas fa-cogs text-primary me-2"></i>Thông Số Kỹ Thuật</h5>
                <table class="table table-striped table-bordered small mb-0">
                    <tbody>
                        <tr>
                            <th style="width: 35%;">Vi xử lý (CPU)</th>
                            <td><?= Security::escape($product['specs_cpu'] ?? 'Đang cập nhật') ?></td>
                        </tr>
                        <tr>
                            <th>Bộ nhớ RAM</th>
                            <td><?= Security::escape($product['specs_ram'] ?? 'Đang cập nhật') ?></td>
                        </tr>
                        <tr>
                            <th>Ổ cứng lưu trữ</th>
                            <td><?= Security::escape($product['specs_storage'] ?? 'Đang cập nhật') ?></td>
                        </tr>
                        <tr>
                            <th>Màn hình</th>
                            <td><?= Security::escape($product['specs_screen'] ?? 'Đang cập nhật') ?></td>
                        </tr>
                        <tr>
                            <th>Thương hiệu</th>
                            <td><?= Security::escape($product['brand']) ?></td>
                        </tr>
                        <tr>
                            <th>Tình trạng máy</th>
                            <td>Mới 100% Nguyên Hộp Fullbox</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RICH TEXT DESCRIPTION -->
        <div class="col-lg-7">
            <div class="card border rounded-4 bg-white p-4 shadow-sm h-100">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="fas fa-file-alt text-primary me-2"></i>Đặc Điểm Nổi Bật &amp; Đánh Giá Chi Tiết</h5>
                <div class="product-description-content text-secondary lh-lg">
                    <?php 
                    // Render mô tả rich text cho phép HTML định dạng an toàn
                    echo !empty($product['description']) ? $product['description'] : '<p class="text-muted">Chưa có bài đánh giá chi tiết cho sản phẩm này.</p>';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- RELATED PRODUCTS -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="mb-4">
            <h4 class="fw-bold mb-3"><i class="fas fa-layer-group text-primary me-2"></i>Sản Phẩm Cùng Hãng <?= Security::escape($product['brand']) ?></h4>
            <div class="row g-3">
                <?php foreach ($relatedProducts as $rp): ?>
                    <div class="col-md-3 col-6">
                        <div class="product-card">
                            <div class="product-card-img-wrap" style="height: 160px;">
                                <img src="uploads/<?= Security::escape($rp['image']) ?>" onerror="this.src='assets/images/dell_vostro.jpg'" alt="<?= Security::escape($rp['name']) ?>">
                            </div>
                            <div class="product-body">
                                <h6 class="product-title" style="height: 38px; font-size: 13px;">
                                    <a href="index.php?r=product/detail&id=<?= $rp['id'] ?>"><?= Security::escape($rp['name']) ?></a>
                                </h6>
                                <div class="text-danger fw-bold small mb-2"><?= number_format($rp['price'], 0, ',', '.') ?> đ</div>
                                <a href="index.php?r=product/detail&id=<?= $rp['id'] ?>" class="btn btn-outline-primary btn-sm w-100">Xem ngay</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>
