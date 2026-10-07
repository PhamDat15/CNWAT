<?php
/**
 * View Admin Products: Danh sách sản phẩm laptop trong khu vực quản trị
 */
?>
<div class="card border-0 rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fas fa-boxes text-primary me-2"></i>Kho Sản Phẩm Laptop</h4>
            <p class="text-secondary small mb-0">Quản lý thêm, sửa, xóa laptop và cấu hình thông số kỹ thuật</p>
        </div>
        <a href="index.php?r=admin/productAdd" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-plus me-1"></i> Thêm Mới Laptop
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 10%;">Ảnh</th>
                    <th style="width: 30%;">Tên sản phẩm</th>
                    <th style="width: 12%;">Hãng</th>
                    <th style="width: 15%;">Giá niêm yết</th>
                    <th style="width: 8%;">Kho</th>
                    <th style="width: 20%;" class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Chưa có sản phẩm nào trong cơ sở dữ liệu.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td><strong>#<?= $p['id'] ?></strong></td>
                            <td>
                                <img src="uploads/<?= Security::escape($p['image']) ?>" onerror="this.src='assets/images/dell_vostro.jpg'" width="50" height="50" class="rounded object-fit-contain bg-light p-1">
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= Security::escape($p['name']) ?></div>
                                <small class="text-muted text-truncate d-block" style="max-width: 280px;"><?= Security::escape($p['specs_cpu'] ?? '') ?></small>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border"><?= Security::escape($p['brand']) ?></span>
                            </td>
                            <td>
                                <div class="text-danger fw-bold"><?= number_format($p['price'], 0, ',', '.') ?> đ</div>
                                <?php if (!empty($p['old_price'])): ?>
                                    <small class="text-muted text-decoration-line-through"><?= number_format($p['old_price'], 0, ',', '.') ?> đ</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle"><?= (int)$p['quantity'] ?></span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="index.php?r=product/detail&id=<?= $p['id'] ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Xem trên web">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="index.php?r=admin/productEdit&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <form action="index.php?r=admin/productDelete" method="POST" class="d-inline">
                                        <?= Security::getCsrfField() ?>
                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-confirm" title="Xóa">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
