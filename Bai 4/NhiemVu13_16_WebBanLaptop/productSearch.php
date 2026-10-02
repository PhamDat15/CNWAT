<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 13: PRODUCTSEARCH.PHP
// ========================================================
include 'header.php';

$keyword = trim($_GET['keyword'] ?? '');
$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
$results = [];

if (isset($conn) && $conn) {
    $where = [];
    if (!empty($keyword)) {
        $kw = mysqli_real_escape_string($conn, $keyword);
        $where[] = "(p.product_name LIKE '%$kw%' OR p.description LIKE '%$kw%')";
    }
    if ($cat_id > 0) {
        $where[] = "p.cat_id = $cat_id";
    }

    $where_sql = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
    $sql = "SELECT p.*, c.cat_name FROM products p JOIN categories c ON p.cat_id = c.id $where_sql ORDER BY p.id DESC";
    $r = mysqli_query($conn, $sql);
    if ($r) {
        while ($row = mysqli_fetch_assoc($r)) {
            $results[] = $row;
        }
    }
}

if (empty($results)) {
    foreach ($SAMPLE_PRODUCTS as $sp) {
        $match = true;
        if (!empty($keyword) && stripos($sp['product_name'], $keyword) === false && stripos($sp['description'], $keyword) === false) {
            $match = false;
        }
        if ($cat_id > 0 && $sp['cat_id'] != $cat_id) {
            $match = false;
        }
        if ($match) {
            $results[] = $sp;
        }
    }
}
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px;">
    <!-- Tiêu đề Search Results theo chuẩn Hình 2 -->
    <div style="background: #b91c1c; color: white; padding: 8px 12px; font-weight: bold; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <span>★ Search results</span>
        <span style="font-size: 12px;">Từ khóa: "<strong><?php echo htmlspecialchars($keyword ?: 'Tất cả'); ?></strong>"</span>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; margin-bottom: 15px; font-size: 13px;">
        <span style="color: #475569;">Products found: <strong><?php echo count($results); ?></strong></span>
        <div>
            Hiển thị theo: 
            <select style="padding: 4px 8px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 12px;">
                <option>Giá bán tăng dần</option>
                <option>Giá bán giảm dần</option>
                <option selected>Sản phẩm mới nhất</option>
            </select>
        </div>
    </div>

    <?php if (!empty($results)): ?>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <?php foreach ($results as $prod): ?>
                <div style="display: flex; gap: 18px; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; background: #fafafa;">
                    <div style="text-align: center;">
                        <a href="productDetail.php?id=<?php echo $prod['id']; ?>">
                            <img src="images/<?php echo htmlspecialchars($prod['image'] ?? 'dell_vostro.jpg'); ?>" style="width: 140px; height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;" onerror="this.src='images/dell_vostro.jpg'">
                        </a>
                        <div style="margin-top: 6px;">
                            <a href="productDetail.php?id=<?php echo $prod['id']; ?>" style="font-size: 12px; color: #2563eb; text-decoration: underline;">View details &raquo;</a>
                        </div>
                    </div>

                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <h4 style="font-size: 15px; margin-bottom: 6px;">
                                <a href="productDetail.php?id=<?php echo $prod['id']; ?>" style="color: #1e3a8a; text-decoration: none;">
                                    <?php echo htmlspecialchars($prod['product_name']); ?>
                                </a>
                            </h4>
                            <p style="font-size: 13px; color: #475569; line-height: 1.5; margin-bottom: 8px;">
                                <?php echo htmlspecialchars($prod['description']); ?>
                            </p>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed #e2e8f0; padding-top: 8px;">
                            <div>
                                <span style="font-size: 12px; color: #64748b;">Giá bán:</span>
                                <span style="color: #dc2626; font-size: 16px; font-weight: bold; margin-left: 6px;">
                                    <?php echo number_format($prod['price'], 0, ',', '.'); ?> VNĐ
                                </span>
                            </div>
                            <a href="cartAdd.php?id=<?php echo $prod['id']; ?>" style="padding: 5px 14px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-size: 13px; font-weight: bold;">
                                + Thêm Vào Giỏ
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="padding: 30px; text-align: center; color: #64748b;">
            <p style="font-size: 15px;">Không tìm thấy sản phẩm nào phù hợp với từ khóa.</p>
            <a href="productList.php" style="color: #2563eb; text-decoration: underline; margin-top: 10px; display: inline-block;">Xem tất cả sản phẩm khác</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
