<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 14 & 16: ADMIN HEADER
// ========================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../connect.php';
$active_script = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Trị LaptopShop | Phạm Tiến Đạt - AT200311</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-sidebar {
            width: 200px;
            background: #f8fafc;
            border-right: 1px solid #cbd5e1;
            padding: 15px 10px;
        }
        .admin-menu-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .admin-menu-list a {
            display: block;
            padding: 8px 12px;
            background: #e2e8f0;
            color: #1e293b;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .admin-menu-list a:hover {
            background: #cbd5e1;
        }
        .admin-menu-list a.active {
            background: #2563eb;
            color: white;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 1px solid #cbd5e1;
            margin-top: 15px;
        }
        .admin-table th {
            background: #f1f5f9;
            padding: 10px;
            border: 1px solid #cbd5e1;
            text-align: left;
            font-size: 13px;
        }
        .admin-table td {
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            font-size: 13px;
        }
    </style>
</head>
<body>
<div class="shop-wrapper">
    <!-- Banner Admin -->
    <div style="background: #1e293b; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 18px; margin: 0;">🛡 LAPTOPSHOP ADMINISTRATION PANEL</h2>
            <p style="font-size: 12px; color: #94a3b8; margin-top: 2px;">Trang Quản Trị Hệ Thống - Phân Hệ Admin (Nhiệm Vụ 14 & 16)</p>
        </div>
        <div style="font-size: 13px;">
            Xin chào: <strong style="color: #60a5fa;">Quản trị viên</strong> &bull; <a href="../index.php" style="color: #f87171; text-decoration: underline;">Thoát Admin</a>
        </div>
    </div>

    <div class="layout-container">
        <!-- Sidebar Admin Menus (như trong ảnh mẫu trang 63-65) -->
        <aside class="admin-sidebar">
            <ul class="admin-menu-list">
                <li><a href="../index.php">Return Home</a></li>
                <li><a href="userList.php" class="<?php echo in_array($active_script, ['userList.php', 'userAdd.php', 'userEdit.php', 'userDetail.php']) ? 'active' : ''; ?>">UsersManage</a></li>
                <li><a href="productList.php" class="<?php echo in_array($active_script, ['productList.php', 'productAdd.php', 'productEdit.php']) ? 'active' : ''; ?>">Products</a></li>
                <li><a href="../index.php" style="background: #fee2e2; color: #dc2626;">Logout</a></li>
            </ul>
        </aside>

        <!-- Main Admin Content Area -->
        <main class="content-right" style="padding: 20px;">
