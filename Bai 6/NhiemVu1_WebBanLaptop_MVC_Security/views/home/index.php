<?php
/**
 * View Home Index: Trang chủ hiển thị 2 sản phẩm mới nhất mỗi hãng & Sản phẩm nổi bật
 */
?>
<div class="container py-4">

    <!-- HERO PROMO BANNER -->
    <div class="hero-slider-wrap mb-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 text-uppercase fw-bold">
                    <i class="fas fa-bolt me-1"></i> Siêu Phẩm Công Nghệ 2026
                </span>
                <h1 class="display-5 fw-extrabold mb-3">Laptop Thế Hệ Mới &bull; Bảo Mật Toàn Diện</h1>
                <p class="lead text-light mb-4" style="opacity: 0.9;">
                    Khám phá các dòng laptop đỉnh cao từ Dell, Asus ROG, MacBook Pro M3, ThinkPad. Nền tảng E-commerce bảo mật chuẩn OWASP Top 10, trải nghiệm mượt mà với AJAX &amp; MVC.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="index.php?r=product/index" class="btn btn-primary btn-lg rounded-pill px-4 shadow">
                        <i class="fas fa-shopping-bag me-2"></i> Khám Phá Sản Phẩm
                    </a>
                    <a href="#brandSection" class="btn btn-outline-light btn-lg rounded-pill px-4">
                        <i class="fas fa-layer-group me-2"></i> Xem Theo Hãng
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <img src="assets/images/banner.jpg" class="img-fluid rounded-4 shadow-lg border border-secondary" alt="Banner Laptop" style="max-height: 280px; object-fit: cover; width: 100%;">
            </div>
        </div>
    </div>

    <!-- QUICK BRAND LOGOS -->
    <div class="mb-5" id="brandSection">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0"><i class="fas fa-tags text-primary me-2"></i>Thương Hiệu Hàng Đầu</h4>
            <a href="index.php?r=product/index" class="text-primary text-decoration-none fw-semibold small">Xem tất cả &rarr;</a>
        </div>
        <div class="row g-3">
            <?php
            $brandCards = [
                ['name' => 'Dell', 'icon' => 'fab fa-windows', 'color' => '#0076CE', 'desc' => 'Bền bỉ, đẳng cấp'],
                ['name' => 'Asus', 'icon' => 'fas fa-microchip', 'color' => '#E02424', 'desc' => 'Sáng tạo, ROG Gaming'],
                ['name' => 'Apple', 'icon' => 'fab fa-apple', 'color' => '#333333', 'desc' => 'MacBook M-Series đỉnh cao'],
                ['name' => 'HP', 'icon' => 'fas fa-desktop', 'color' => '#0096D6', 'desc' => 'Sang trọng, đa nhiệm'],
                ['name' => 'Lenovo', 'icon' => 'fas fa-keyboard', 'color' => '#E2231A', 'desc' => 'ThinkPad gõ sướng nhất'],
                ['name' => 'Acer', 'icon' => 'fas fa-gamepad', 'color' => '#83B81A', 'desc' => 'Cấu hình cao, giá tốt']
            ];
            foreach ($brandCards as $b): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="index.php?r=product/index&brand=<?= urlencode($b['name']) ?>" class="card text-center p-3 h-100 border text-decoration-none bg-white rounded-3 shadow-sm hover-shadow" style="transition: all 0.2s;">
                        <i class="<?= $b['icon'] ?> fa-2x mb-2" style="color: <?= $b['color'] ?>;"></i>
                        <h6 class="fw-bold text-dark mb-0"><?= $b['name'] ?></h6>
                        <small class="text-muted" style="font-size: 11px;"><?= $b['desc'] ?></small>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 2 SẢN PHẨM MỚI NHẤT MỖI HÃNG (YÊU CẦU ĐỀ BÀI) -->
    <div class="mb-5">
        <div class="border-bottom pb-2 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="fas fa-fire text-danger me-2"></i>2 Sản Phẩm Mới Nhất Từng Hãng
                </h3>
                <p class="text-muted small mb-0">Hiển thị chính xác 2 laptop mới nhất cập nhật theo từng thương hiệu (Đặc tả Lab 4 &amp; Lab 6)</p>
            </div>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                Cập nhật tự động
            </span>
        </div>

        <?php foreach ($brandProducts as $brandName => $products): ?>
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-primary fs-6 px-3 py-2 rounded-3"><i class="fas fa-laptop me-2"></i>Hãng <?= Security::escape($brandName) ?></span>
                    <a href="index.php?r=product/index&brand=<?= urlencode($brandName) ?>" class="small text-muted ms-auto text-decoration-none">
                        Xem thêm dòng <?= Security::escape($brandName) ?> &rarr;
                    </a>
                </div>

                <div class="row g-3">
                    <?php foreach ($products as $p): ?>
                        <div class="col-md-6 col-lg-6">
                            <div class="card border rounded-3 p-3 bg-white h-100 shadow-sm hover-shadow">
                                <div class="row g-3 align-items-center">
                                    <div class="col-sm-5 text-center">
                                        <div style="height: 150px; display: flex; align-items: center; justify-content: center; background: #f8fafc; border-radius: 8px;">
                                            <img src="uploads/<?= Security::escape($p['image']) ?>" onerror="this.src='assets/images/dell_vostro.jpg'" alt="<?= Security::escape($p['name']) ?>" style="max-height: 130px; max-width: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <span class="badge bg-light text-primary border mb-1"><?= Security::escape($p['brand']) ?></span>
                                        <h5 class="fw-bold mb-1 text-truncate" title="<?= Security::escape($p['name']) ?>">
                                            <a href="index.php?r=product/detail&id=<?= $p['id'] ?>" class="text-dark text-decoration-none">
                                                <?= Security::escape($p['name']) ?>
                                            </a>
                                        </h5>
                                        <p class="text-muted small mb-2 text-truncate"><?= Security::escape($p['specs_cpu'] ?? 'Cấu hình cao cấp') ?></p>
                                        <div class="d-flex align-items-baseline gap-2 mb-3">
                                            <span class="text-danger fw-extrabold fs-5"><?= number_format($p['price'], 0, ',', '.') ?> đ</span>
                                            <?php if (!empty($p['old_price'])): ?>
                                                <small class="text-muted text-decoration-line-through"><?= number_format($p['old_price'], 0, ',', '.') ?> đ</small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="index.php?r=product/detail&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-secondary">
                                                Chi tiết
                                            </a>
                                            <button class="btn btn-sm btn-primary btn-add-cart-ajax" data-id="<?= $p['id'] ?>">
                                                <i class="fas fa-cart-plus me-1"></i> Thêm giỏ
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- SECURITY ARCHITECTURE OVERVIEW -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 my-5">
        <h4 class="fw-bold text-dark mb-3"><i class="fas fa-shield-alt text-success me-2"></i>Kiến Trúc An Toàn Web Tích Hợp (Security Compliance)</h4>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="p-3 bg-light rounded-3 h-100">
                    <div class="text-primary fw-bold mb-1"><i class="fas fa-database me-1"></i> PDO Prepared Statements</div>
                    <small class="text-secondary">Ngăn chặn triệt để SQL Injection bằng cách phân tách dữ liệu và lệnh truy vấn.</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light rounded-3 h-100">
                    <div class="text-success fw-bold mb-1"><i class="fas fa-code me-1"></i> XSS Output Escaping</div>
                    <small class="text-secondary">Mã hóa HTML ký tự đặc biệt với htmlspecialchars ENT_QUOTES và Content-Security-Policy.</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light rounded-3 h-100">
                    <div class="text-danger fw-bold mb-1"><i class="fas fa-user-lock me-1"></i> CSRF Token Defense</div>
                    <small class="text-secondary">Mỗi Form và State-changing request đều được bảo vệ bởi mã CSRF Token duy nhất trong session.</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light rounded-3 h-100">
                    <div class="text-warning fw-bold mb-1"><i class="fas fa-key me-1"></i> Bcrypt &amp; Rate Limit</div>
                    <small class="text-secondary">Băm mật khẩu Bcrypt an toàn một chiều; chặn Brute Force sau 5 lần thử đăng nhập sai.</small>
                </div>
            </div>
        </div>
    </div>

</div>
