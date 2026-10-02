<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 13: END USER INDEX.PHP
// ========================================================
include 'header.php';

// Yêu cầu đề bài: "Trang home: hiển thị mỗi loại 2 sản phẩm mới nhất"
$grouped_products = [];

if (isset($conn) && $conn) {
    foreach ($categories as $c) {
        $cid = intval($c['id']);
        $sql = "SELECT p.*, c.cat_name FROM products p JOIN categories c ON p.cat_id = c.id WHERE p.cat_id = $cid ORDER BY p.id DESC LIMIT 2";
        $r = mysqli_query($conn, $sql);
        if ($r && mysqli_num_rows($r) > 0) {
            $grouped_products[$c['cat_name']] = [];
            while ($p = mysqli_fetch_assoc($r)) {
                $grouped_products[$c['cat_name']][] = $p;
            }
        }
    }
}

// Fallback nếu CSDL chưa có dữ liệu
if (empty($grouped_products)) {
    $grouped_products['Laptop DELL'] = [
        $SAMPLE_PRODUCTS[1],
        $SAMPLE_PRODUCTS[2]
    ];
    $grouped_products['Laptop HP & ASUS'] = [
        $SAMPLE_PRODUCTS[3],
        $SAMPLE_PRODUCTS[5]
    ];
}
?>

<div style="background: #eef2ff; border-left: 4px solid #3b82f6; padding: 12px 18px; border-radius: 4px; margin-bottom: 20px;">
    <h3 style="color: #1e40af; margin-bottom: 4px;">Sản Phẩm Mới Nhất Từng Danh Mục</h3>
    <p style="font-size: 13px; color: #475569;">Trang chủ hiển thị tự động <strong>2 sản phẩm mới nhất</strong> theo từng dòng máy tính xách tay.</p>
</div>

<?php foreach ($grouped_products as $cat_title => $prods): ?>
    <div style="margin-bottom: 25px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #b91c1c; padding-bottom: 6px;">
            <h3 style="color: #b91c1c; font-size: 16px; text-transform: uppercase;">
                ⭐ <?php echo htmlspecialchars($cat_title); ?>
            </h3>
            <a href="productList.php" style="color: #2563eb; font-size: 12px; font-weight: bold; text-decoration: underline;">Xem tất cả &rarr;</a>
        </div>

        <div class="products-grid">
            <?php foreach ($prods as $prod): ?>
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
    </div>
<?php endforeach; ?>

<?php include 'footer.php'; ?>
