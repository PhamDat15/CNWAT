<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 13-16: HEADER.PHP
// ========================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/connect.php';

// Tính tổng số lượng hàng trong giỏ
$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['qty'];
    }
}

// Lấy danh sách Categories từ CSDL hoặc mảng mẫu
$categories = [];
if (isset($conn) && $conn) {
    $r_cat = mysqli_query($conn, "SELECT * FROM categories ORDER BY id ASC");
    if ($r_cat) {
        while ($rc = mysqli_fetch_assoc($r_cat)) {
            $categories[] = $rc;
        }
    }
}
if (empty($categories)) {
    $categories = array_values($SAMPLE_CATEGORIES);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaptopShop.vn - Cổng Bán Máy Tính Xách Tay Chuyên Nghiệp | Phạm Tiến Đạt - AT200311</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="shop-wrapper">
    <!-- Top Header Bar -->
    <div class="top-header">
        <div><strong>0.985. KÍNH CHÀO QUÝ KHÁCH</strong> &bull; Hotline: 1800 6601</div>
        
        <!-- Form Search -->
        <form class="search-box-bar" method="GET" action="productSearch.php">
            <span>Tìm kiếm:</span>
            <input type="text" name="keyword" placeholder="Nhập tên sản phẩm..." value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
            <select name="cat_id">
                <option value="0">Tất cả hãng</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['cat_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Tìm</button>
        </form>

        <!-- Cart View Button -->
        <a href="cartView.php" class="cart-btn">
            🛒 Giỏ hàng (<strong><?php echo $cart_count; ?></strong>)
        </a>
    </div>

    <!-- Main Banner -->
    <div class="main-banner">
        <div>
            <h1>💻 LaptopShop.vn - Thế Giới Máy Tính Xách Tay</h1>
            <p>Hệ thống phân phối laptop chính hãng hàng đầu Việt Nam - Dự án Thực Hành PHP & CSDL</p>
        </div>
        <div style="font-size: 12px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 6px; text-align: right;">
            SVTH: <strong>Phạm Tiến Đạt</strong><br>
            MSSV: <strong>AT200311</strong> - Lớp AT20A
        </div>
    </div>

    <!-- Navigation -->
    <nav class="main-nav">
        <ul class="nav-links">
            <li><a href="index.php">Trang Chủ</a></li>
            <li><a href="productList.php">Tất Cả Sản Phẩm</a></li>
            <li><a href="productSearch.php">Tìm Kiếm Nâng Cao</a></li>
            <li><a href="cartView.php">Giỏ Hàng</a></li>
        </ul>
        <ul class="nav-links">
            <li><a href="admin/userList.php" style="background: #b91c1c; color: white;">⚙️ Khu Vực Admin</a></li>
            <li><a href="../NhiemVu01_Template/index.php" style="background: #334155; color: #f8fafc;">&larr; Về Menu Bài 4</a></li>
        </ul>
    </nav>

    <!-- Content Layout -->
    <div class="layout-container">
        <!-- Sidebar Left -->
        <aside class="sidebar-left">
            <div class="cat-title">DANH MỤC LAPTOP</div>
            <ul class="cat-list">
                <?php foreach ($categories as $cat): ?>
                    <li>
                        <a href="productList.php?cat_id=<?php echo $cat['id']; ?>">
                            &rsaquo; <?php echo htmlspecialchars($cat['cat_name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="promo-box">
                <h4 style="color: #dc2626; font-size: 13px; text-transform: uppercase;">MUA LAPTOP TRẢ GÓP</h4>
                <p style="font-size: 12px; color: #475569; margin-top: 4px;">Lãi suất 0% - Duyệt hồ sơ nhanh chóng trong 15 phút!</p>
            </div>

            <div style="margin-top: 15px; background: #e0f2fe; padding: 12px; border-radius: 6px; border: 1px solid #bae6fd;">
                <h4 style="color: #0369a1; font-size: 13px;">HỖ TRỢ ONLINE</h4>
                <p style="font-size: 12px; color: #0c4a6e; margin-top: 4px;">
                    📞 Kinh doanh: 0985.xxx.xxx<br>
                    🛡 Kỹ thuật KMA: AT200311
                </p>
            </div>
        </aside>

        <!-- Right Content Body -->
        <main class="content-right">
