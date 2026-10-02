<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 13: PRODUCTDETAIL.PHP
// ========================================================
include 'header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if (isset($conn) && $conn && $id > 0) {
    $sql = "SELECT p.*, c.cat_name FROM products p JOIN categories c ON p.cat_id = c.id WHERE p.id = $id";
    $res = mysqli_query($conn, $sql);
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $product = $row;
    }
}

if (!$product && isset($SAMPLE_PRODUCTS[$id])) {
    $product = $SAMPLE_PRODUCTS[$id];
    $product['cat_name'] = $SAMPLE_CATEGORIES[$product['cat_id']]['cat_name'] ?? 'Laptop Chính Hãng';
}
?>

<div style="margin-bottom: 15px;">
    <a href="productList.php" style="color: #2563eb; text-decoration: underline; font-size: 13px;">&larr; Quay lại danh sách sản phẩm</a>
</div>

<?php if ($product): ?>
    <div class="detail-box">
        <div class="detail-header">
            <div>
                <img src="images/<?php echo htmlspecialchars($product['image'] ?? 'dell_vostro.jpg'); ?>" alt="Laptop" class="detail-img" onerror="this.src='images/dell_vostro.jpg'">
                <p style="text-align: center; margin-top: 8px; font-size: 12px; color: #64748b;">(Hình ảnh thực tế sản phẩm)</p>
            </div>

            <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <span style="background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">
                        <?php echo htmlspecialchars($product['cat_name'] ?? 'Laptop'); ?>
                    </span>
                    <h2 style="color: #1e3a8a; font-size: 20px; margin: 8px 0 12px 0;">
                        <?php echo htmlspecialchars($product['product_name']); ?>
                    </h2>
                    
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; margin-bottom: 15px;">
                        <span style="font-size: 12px; color: #64748b;">Giá bán chính hãng (Chưa bao gồm 10% VAT):</span>
                        <div style="color: #dc2626; font-size: 24px; font-weight: bold; margin-top: 4px;">
                            <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ
                        </div>
                    </div>

                    <div style="line-height: 1.8; font-size: 14px; color: #334155;">
                        <p><strong>Bảo hành:</strong> 12 tháng chính hãng (Đổi mới trong 30 ngày nếu lỗi NSX)</p>
                        <p><strong>Tình trạng máy:</strong> Hàng mới 100% nguyên seal, đầy đủ phụ kiện sạc zin</p>
                        <p><strong>Giao hàng:</strong> Miễn phí vận chuyển toàn quốc cho sinh viên KMA</p>
                    </div>
                </div>

                <div style="margin-top: 20px; display: flex; gap: 12px;">
                    <a href="cartAdd.php?id=<?php echo $product['id']; ?>" style="padding: 10px 24px; background: #dc2626; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 15px; display: inline-flex; align-items: center; gap: 8px;">
                        🛒 MUA NGAY (THÊM VÀO GIỎ)
                    </a>
                </div>
            </div>
        </div>

        <div style="border-top: 2px solid #e2e8f0; padding-top: 20px; margin-top: 20px;">
            <h3 style="color: #1e40af; font-size: 16px; margin-bottom: 10px;">THÔNG SỐ KỸ THUẬT &amp; MÔ TẢ CHI TIẾT</h3>
            <div style="line-height: 1.8; color: #334155; font-size: 14px; background: #fafafa; padding: 15px; border-radius: 6px; border: 1px solid #f1f5f9;">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div style="background: white; padding: 30px; text-align: center; border-radius: 8px;">
        <p style="color: red; font-size: 16px;">Không tìm thấy thông tin sản phẩm!</p>
        <a href="productList.php" style="color: #2563eb; text-decoration: underline; margin-top: 10px; display: inline-block;">&larr; Trở lại danh sách</a>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
