<?php
/**
 * View Product Index: Danh mục laptop với bộ lọc đa tiêu chí và phân trang
 */
$selectedBrand = $filters['brand'] ?? '';
$minPrice = $filters['min_price'] ?? '';
$maxPrice = $filters['max_price'] ?? '';
$search = $filters['search'] ?? '';
?>
<div class="container py-4">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?r=home/index">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh mục Laptop</li>
            <?php if (!empty($selectedBrand)): ?>
                <li class="breadcrumb-item active"><?= Security::escape($selectedBrand) ?></li>
            <?php endif; ?>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- FILTER SIDEBAR -->
        <div class="col-lg-3">
            <div class="card border rounded-3 p-3 bg-white shadow-sm sticky-top" style="top: 90px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-filter text-primary me-2"></i>Bộ Lọc Sản Phẩm</h5>
                    <a href="index.php?r=product/index" class="text-danger small text-decoration-none">Đặt lại</a>
                </div>

                <form action="index.php" method="GET" id="filterForm">
                    <input type="hidden" name="r" value="product/index">

                    <!-- Lọc theo từ khóa -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Từ khóa tìm kiếm:</label>
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Tên máy, cấu hình..." value="<?= Security::escape($search) ?>">
                    </div>

                    <!-- Lọc theo Hãng -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Thương hiệu:</label>
                        <select name="brand" class="form-select form-select-sm">
                            <option value="">-- Tất cả thương hiệu --</option>
                            <?php foreach (['Dell', 'Asus', 'Apple', 'HP', 'Lenovo', 'Acer'] as $b): ?>
                                <option value="<?= $b ?>" <?= ($selectedBrand === $b) ? 'selected' : '' ?>><?= $b ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Lọc theo Khoảng giá -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Khoảng giá (VNĐ):</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Từ" value="<?= Security::escape($minPrice) ?>">
                            </div>
                            <div class="col-6">
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Đến" value="<?= Security::escape($maxPrice) ?>">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search me-1"></i> Áp Dụng Bộ Lọc
                    </button>
                </form>
            </div>
        </div>

        <!-- PRODUCT LIST CONTENT -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 rounded-3 border shadow-sm">
                <div>
                    <h4 class="fw-bold mb-0">Tất Cả Laptop Chính Hãng</h4>
                    <small class="text-muted">Tìm thấy <?= $totalItems ?> sản phẩm phù hợp</small>
                </div>
            </div>

            <?php if (empty($products)): ?>
                <div class="text-center py-5 bg-white rounded-3 border shadow-sm">
                    <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                    <h5>Không tìm thấy sản phẩm nào!</h5>
                    <p class="text-muted small">Vui lòng thử lại với các tiêu chí tìm kiếm hoặc khoảng giá khác.</p>
                    <a href="index.php?r=product/index" class="btn btn-outline-primary btn-sm">Xem tất cả sản phẩm</a>
                </div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($products as $p): ?>
                        <div class="col-md-6 col-xl-4">
                            <div class="product-card">
                                <div class="product-card-img-wrap">
                                    <span class="badge-brand"><?= Security::escape($p['brand']) ?></span>
                                    <?php if (!empty($p['old_price']) && $p['old_price'] > $p['price']): ?>
                                        <span class="badge-discount-tag">
                                            -<?= round((($p['old_price'] - $p['price']) / $p['old_price']) * 100) ?>%
                                        </span>
                                    <?php endif; ?>
                                    <img src="uploads/<?= Security::escape($p['image']) ?>" onerror="this.src='assets/images/dell_vostro.jpg'" alt="<?= Security::escape($p['name']) ?>">
                                </div>

                                <div class="product-body">
                                    <h5 class="product-title" title="<?= Security::escape($p['name']) ?>">
                                        <a href="index.php?r=product/detail&id=<?= $p['id'] ?>">
                                            <?= Security::escape($p['name']) ?>
                                        </a>
                                    </h5>

                                    <div class="small text-muted mb-2 text-truncate">
                                        <i class="fas fa-microchip me-1"></i> <?= Security::escape($p['specs_cpu'] ?? 'Core i5') ?>
                                    </div>

                                    <div class="mt-auto">
                                        <div class="d-flex align-items-baseline mb-3">
                                            <span class="product-price-current"><?= number_format($p['price'], 0, ',', '.') ?> đ</span>
                                            <?php if (!empty($p['old_price'])): ?>
                                                <span class="product-price-old"><?= number_format($p['old_price'], 0, ',', '.') ?> đ</span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <a href="index.php?r=product/detail&id=<?= $p['id'] ?>" class="btn btn-outline-secondary btn-sm flex-fill">
                                                Chi tiết
                                            </a>
                                            <button class="btn btn-primary btn-sm flex-fill btn-add-cart-ajax" data-id="<?= $p['id'] ?>">
                                                <i class="fas fa-cart-plus me-1"></i> Mua ngay
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- PHÂN TRANG -->
                <?php if ($totalPages > 1): ?>
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($currentPage === $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="index.php?r=product/index&page=<?= $i ?>&brand=<?= urlencode($selectedBrand) ?>&min_price=<?= urlencode($minPrice) ?>&max_price=<?= urlencode($maxPrice) ?>&search=<?= urlencode($search) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</div>
