<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 13: PRODUCTLIST.PHP
// ========================================================
include 'header.php';

$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
$cat_name = "Tất cả sản phẩm laptop";
$products = [];

if (isset($conn) && $conn) {
    if ($cat_id > 0) {
        $q_cat = mysqli_query($conn, "SELECT cat_name FROM categories WHERE id = $cat_id");
        if ($q_cat && $r_c = mysqli_fetch_assoc($q_cat)) {
            $cat_name = $r_c['cat_name'];
        }
        $sql = "SELECT p.*, c.cat_name FROM products p JOIN categories c ON p.cat_id = c.id WHERE p.cat_id = $cat_id ORDER BY p.id DESC";
    } else {
        $sql = "SELECT p.*, c.cat_name FROM products p JOIN categories c ON p.cat_id = c.id ORDER BY p.id DESC";
    }
    $r = mysqli_query($conn, $sql);
    if ($r) {
        while ($p = mysqli_fetch_assoc($r)) {
            $products[] = $p;
        }
    }
}

// Fallback nếu CSDL chưa kết nối
if (empty($products)) {
    if ($cat_id > 0) {
        foreach ($SAMPLE_PRODUCTS as $sp) {
            if ($sp['cat_id'] == $cat_id) {
                $products[] = $sp;
            }
        }
    } else {
        $products = array_values($SAMPLE_PRODUCTS);
    }
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #b91c1c; padding-bottom: 6px; margin-bottom: 15px;">
    <h3 style="color: #b91c1c; font-size: 16px; text-transform: uppercase;">
        💻 <?php echo htmlspecialchars($cat_name); ?> (<?php echo count($products); ?> sản phẩm)
    </h3>
    <span style="font-size: 12px; color: #64748b;">Nhấp vào ảnh hoặc tên để xem chi tiết</span>
</div>

<?php if (!empty($products)): ?>
    <div class="products-grid">
        <?php foreach ($products as $prod): ?>
            <div class="product-card">
                <a href="productDetail.php?id=<?php echo $prod['id']; ?>">
                    <img src="images/<?php echo htmlspecialchars($prod['image'] ?? 'dell_vostro.jpg'); ?>" alt="Laptop" onerror="this.src='images/dell_vostro.jpg'">
                </a>
                <div class="product-info">
                    <h4>
                        <a href="productDetail.php?id=<?php echo $prod['id']; ?>">
                            <?php echo htmlspecialchars($prod['product_name']); ?>
                        </a>
                    </h4>
                    <p class="product-desc"><?php echo htmlspecialchars($prod['description']); ?></p>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 6px;">
                        <span class="product-price"><?php echo number_format($prod['price'], 0, ',', '.'); ?> VNĐ</span>
                        <a href="cartAdd.php?id=<?php echo $prod['id']; ?>" class="btn-buy">+ Giỏ hàng</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div style="background: white; padding: 30px; text-align: center; border: 1px dashed #cbd5e1; border-radius: 8px;">
        <p style="color: #64748b; font-size: 15px;">Hiện tại danh mục này chưa có sản phẩm nào.</p>
        <a href="productList.php" style="display: inline-block; margin-top: 10px; color: #2563eb; font-weight: bold;">Xem tất cả sản phẩm khác &rarr;</a>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
