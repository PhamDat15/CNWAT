<?php
/**
 * View Admin Product Form: Thêm mới hoặc chỉnh sửa laptop
 * Tích hợp Rich Text Editor (Quill.js), Datetime Picker (Flatpickr), Upload ảnh an toàn và CSRF Protection
 */

$isEdit = !empty($product);
$actionUrl = $isEdit ? "index.php?r=admin/productEdit&id={$product['id']}" : "index.php?r=admin/productAdd";
?>
<div class="card border-0 rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-edit text-primary me-2"></i><?= $isEdit ? 'Chỉnh Sửa Thông Tin Laptop' : 'Thêm Mới Laptop Vào Kho' ?>
            </h4>
            <p class="text-secondary small mb-0">Tích hợp Rich Text Editor &amp; Datetime Picker chuẩn đặc tả thực hành Lab 6</p>
        </div>
        <a href="index.php?r=admin/products" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger small shadow-sm">
            <ul class="mb-0 ps-3">
                <?php foreach ($errors as $err): ?>
                    <li><?= Security::escape($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= $actionUrl ?>" method="POST" enctype="multipart/form-data" id="productForm">
        <?= Security::getCsrfField() ?>

        <div class="row g-3">
            <!-- TÊN SẢN PHẨM -->
            <div class="col-md-8">
                <label class="form-label fw-semibold small">Tên sản phẩm Laptop <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Ví dụ: Dell XPS 13 Plus 9320 Core i7" value="<?= Security::escape($product['name'] ?? '') ?>" required>
            </div>

            <!-- THƯƠNG HIỆU -->
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Hãng sản xuất <span class="text-danger">*</span></label>
                <select name="brand" class="form-select" required>
                    <?php 
                    $currBrand = $product['brand'] ?? 'Dell';
                    foreach (['Dell', 'Asus', 'Apple', 'HP', 'Lenovo', 'Acer'] as $brand): ?>
                        <option value="<?= $brand ?>" <?= ($currBrand === $brand) ? 'selected' : '' ?>><?= $brand ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- GIÁ BÁN & GIÁ CŨ -->
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Giá bán chính thức (VNĐ) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" placeholder="Ví dụ: 25000000" value="<?= Security::escape($product['price'] ?? '') ?>" required min="100000">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold small">Giá niêm yết cũ (Tùy chọn)</label>
                <input type="number" name="old_price" class="form-control" placeholder="Ví dụ: 28000000" value="<?= Security::escape($product['old_price'] ?? '') ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold small">Số lượng tồn kho</label>
                <input type="number" name="quantity" class="form-control" value="<?= Security::escape($product['quantity'] ?? '10') ?>" min="0">
            </div>

            <!-- THÔNG SỐ KỸ THUẬT -->
            <div class="col-12 mt-4">
                <h6 class="fw-bold text-dark border-bottom pb-2"><i class="fas fa-microchip text-primary me-2"></i>Cấu Hình Phần Cứng Chi Tiết</h6>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Vi xử lý (CPU)</label>
                <input type="text" name="specs_cpu" class="form-control form-control-sm" placeholder="Ví dụ: Intel Core i7-1360P 12 Cores" value="<?= Security::escape($product['specs_cpu'] ?? '') ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Bộ nhớ RAM</label>
                <input type="text" name="specs_ram" class="form-control form-control-sm" placeholder="Ví dụ: 16GB DDR5 5200MHz" value="<?= Security::escape($product['specs_ram'] ?? '') ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Ổ cứng (SSD/HDD)</label>
                <input type="text" name="specs_storage" class="form-control form-control-sm" placeholder="Ví dụ: 512GB PCIe Gen4 NVMe" value="<?= Security::escape($product['specs_storage'] ?? '') ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Màn hình hiển thị</label>
                <input type="text" name="specs_screen" class="form-control form-control-sm" placeholder="Ví dụ: 14.0 inch 2.8K 90Hz OLED" value="<?= Security::escape($product['specs_screen'] ?? '') ?>">
            </div>

            <!-- NGÀY PHÁT HÀNH TÍCH HỢP DATETIME PICKER (FLATPICKR) -->
            <div class="col-md-6 mt-3">
                <label class="form-label fw-semibold small">
                    <i class="fas fa-calendar-alt text-primary me-1"></i> Ngày ra mắt / Ngày nhập kho (Datetime Picker)
                </label>
                <input type="text" id="createdAtPicker" name="created_at" class="form-control" placeholder="Chọn ngày giờ..." value="<?= Security::escape($product['created_at'] ?? date('Y-m-d H:i')) ?>">
                <small class="text-muted" style="font-size: 11px;">Tích hợp thư viện Open Source Flatpickr Datetime Picker theo yêu cầu bài thực hành</small>
            </div>

            <!-- UPLOAD HÌNH ẢNH AN TOÀN -->
            <div class="col-md-6 mt-3">
                <label class="form-label fw-semibold small">
                    <i class="fas fa-image text-primary me-1"></i> Tải ảnh đại diện Laptop (File Upload)
                </label>
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                <small class="text-muted" style="font-size: 11px;">Chấp nhận JPG, PNG, WEBP tối đa 5MB. Máy chủ kiểm duyệt nghiêm ngặt MIME Type.</small>
                <?php if ($isEdit && !empty($product['image'])): ?>
                    <div class="mt-2 d-flex align-items-center gap-2">
                        <small class="text-secondary">Ảnh hiện tại:</small>
                        <img src="uploads/<?= Security::escape($product['image']) ?>" onerror="this.src='assets/images/dell_vostro.jpg'" width="40" height="40" class="rounded border object-fit-contain p-1">
                        <span class="small text-muted font-monospace"><?= Security::escape($product['image']) ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- MÔ TẢ NGẮN -->
            <div class="col-12 mt-3">
                <label class="form-label fw-semibold small">Mô tả ngắn gọn sản phẩm</label>
                <textarea name="short_desc" class="form-control" rows="2" placeholder="Tóm tắt điểm mạnh nổi bật trong 1-2 câu..."><?= Security::escape($product['short_desc'] ?? '') ?></textarea>
            </div>

            <!-- MÔ TẢ CHI TIẾT TÍCH HỢP RICH TEXT EDITOR (QUILL.JS) -->
            <div class="col-12 mt-3">
                <label class="form-label fw-semibold small">
                    <i class="fas fa-pen-nib text-primary me-1"></i> Bài viết đánh giá &amp; Mô tả chi tiết (Rich Text Editor - WYSIWYG)
                </label>
                <!-- Container cho Quill Editor -->
                <div id="quillEditor" style="height: 250px; background: white; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    <?= $product['description'] ?? '<p>Nhập bài viết đánh giá chi tiết sản phẩm tại đây với thanh công cụ định dạng Rich Text...</p>' ?>
                </div>
                <!-- Hidden input để gửi dữ liệu HTML về Controller -->
                <input type="hidden" name="description" id="hiddenDescription">
                <small class="text-muted d-block mt-1" style="font-size: 11px;">Tích hợp thư viện WYSIWYG Editor Quill.js hiện đại theo đúng yêu cầu đề bài Lab</small>
            </div>

            <!-- BUTTONS -->
            <div class="col-12 mt-4 pt-3 border-top d-flex gap-2">
                <a href="index.php?r=admin/products" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary px-5 shadow-sm">
                    <i class="fas fa-save me-1"></i> <?= $isEdit ? 'Lưu Cập Nhật Laptop' : 'Thêm Mới Vào Cơ Sở Dữ Liệu' ?>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- KHỞI TẠO RICH TEXT EDITOR & DATETIME PICKER -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Khởi tạo Flatpickr Datetime Picker
    flatpickr("#createdAtPicker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        locale: "vn"
    });

    // 2. Khởi tạo Quill Rich Text Editor
    const quill = new Quill('#quillEditor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['blockquote', 'code-block'],
                ['link', 'clean']
            ]
        }
    });

    // 3. Đồng bộ HTML từ Quill vào Hidden Input trước khi submit Form
    const productForm = document.getElementById('productForm');
    const hiddenDescription = document.getElementById('hiddenDescription');

    productForm.addEventListener('submit', function() {
        hiddenDescription.value = quill.root.innerHTML;
    });
});
</script>
