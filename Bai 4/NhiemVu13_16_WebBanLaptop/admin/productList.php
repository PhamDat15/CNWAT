<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 14 & 16: PRODUCTLIST.PHP
// ========================================================
include 'header.php';

$products = [];
if (isset($conn) && $conn) {
    $sql = "SELECT p.*, c.cat_name FROM products p JOIN categories c ON p.cat_id = c.id ORDER BY p.id DESC";
    $r = mysqli_query($conn, $sql);
    if ($r) {
        while ($row = mysqli_fetch_assoc($r)) {
            $products[] = $row;
        }
    }
}

if (empty($products)) {
    $products = array_values($SAMPLE_PRODUCTS);
    foreach ($products as &$p) {
        $p['cat_name'] = $SAMPLE_CATEGORIES[$p['cat_id']]['cat_name'] ?? 'Laptop';
    }
}
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #b91c1c; padding-bottom: 8px; margin-bottom: 15px;">
        <h3 style="color: #b91c1c; margin: 0; font-size: 16px;">💻 QUẢN LÝ SẢN PHẨM LAPTOP (PRODUCTS LIST)</h3>
        <a href="productAdd.php" style="padding: 6px 14px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">+ Add news Product</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 50px; text-align: center;">ID</th>
                <th style="width: 70px; text-align: center;">Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th style="width: 130px;">Hãng / Danh mục</th>
                <th style="width: 120px; text-align: right;">Giá bán</th>
                <th style="width: 140px; text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
                <td style="text-align: center; font-weight: bold;"><?php echo $p['id']; ?></td>
                <td style="text-align: center;">
                    <img src="images/<?php echo htmlspecialchars($p['image'] ?? 'dell_vostro.jpg'); ?>" style="width: 50px; height: 38px; object-fit: cover; border-radius: 3px;" onerror="this.src='images/dell_vostro.jpg'">
                </td>
                <td>
                    <strong style="color: #1e3a8a;"><?php echo htmlspecialchars($p['product_name']); ?></strong>
                    <div style="font-size: 12px; color: #64748b;"><?php echo htmlspecialchars(substr($p['description'] ?? '', 0, 80)) . '...'; ?></div>
                </td>
                <td><span style="background: #e0f2fe; color: #0284c7; padding: 2px 6px; border-radius: 3px; font-size: 12px; font-weight: bold;"><?php echo htmlspecialchars($p['cat_name'] ?? 'Laptop'); ?></span></td>
                <td style="text-align: right; font-weight: bold; color: #dc2626;">
                    <?php echo number_format($p['price'], 0, ',', '.'); ?> đ
                </td>
                <td style="text-align: center;">
                    <a href="../productDetail.php?id=<?php echo $p['id']; ?>" target="_blank" style="color: #2563eb; text-decoration: underline; margin-right: 5px;">Xem</a> | 
                    <a href="productAdd.php?edit_id=<?php echo $p['id']; ?>" style="color: #059669; text-decoration: underline; margin: 0 5px;">Sửa</a> | 
                    <a href="productDelete.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?');" style="color: #dc2626; text-decoration: underline; margin-left: 5px;">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
