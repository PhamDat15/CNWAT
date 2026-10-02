<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 5: ADMIN MASTER
// ========================================================
session_start();
$admin_page = $_GET['page'] ?? 'home';
$is_logged_in = isset($_SESSION['Username']) && !empty($_SESSION['Username']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khu Vực Quản Trị (Admin Panel) | Phạm Tiến Đạt - AT200311</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .admin-nav a {
            padding: 8px 12px;
            background: #e2e8f0;
            border-radius: 4px;
            text-decoration: none;
            color: #1e293b;
            font-weight: 600;
            border-left: 4px solid transparent;
        }
        .admin-nav a.active {
            background: #2563eb;
            color: white;
            border-left-color: #1d4ed8;
        }
        .admin-nav a:hover:not(.active) {
            background: #cbd5e1;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <header>
        <div class="student-info">
            <p><strong>Thông tin của sinh viên:</strong></p>
            <p>Họ và tên: Phạm Tiến Đạt</p>
            <p>MSSV: AT200311</p>
            <p>Lớp: AT20A</p>
            <img src="../images/avatar.jpg" alt="Avatar" width="80" height="80">
        </div>
        <div class="banner">
            <img src="../images/banner.jpg" alt="Banner Bác Hồ">
        </div>
    </header>

    <div class="container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar" style="width: 200px;">
            <div class="admin-nav">
                <a href="../index.php">Return Home</a>
                <?php if ($is_logged_in): ?>
                    <a href="index.php?page=home" class="<?php echo ($admin_page == 'home') ? 'active' : ''; ?>">Admin Home</a>
                    <a href="index.php?page=upload" class="<?php echo ($admin_page == 'upload') ? 'active' : ''; ?>">Upload</a>
                    <a href="logout.php" style="background: #fee2e2; color: #dc2626;">Logout</a>
                <?php endif; ?>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content">
                <?php if (!$is_logged_in): ?>
                    <!-- Thông báo khi chưa đăng nhập theo đúng yêu cầu đề bài -->
                    <div style="background: white; border: 2px solid #ef4444; border-radius: 8px; padding: 30px; text-align: center; margin: 30px auto; max-width: 480px;">
                        <h3 style="color: #dc2626; margin-bottom: 12px; font-size: 20px;">⚠️ Chưa đăng nhập</h3>
                        <p style="color: #475569; margin-bottom: 20px; line-height: 1.6;">
                            Bạn không có quyền truy cập vào các chức năng quản trị. Vui lòng đăng nhập từ trang người dùng để tiếp tục!
                        </p>
                        <a href="../index.php?page=login" style="display: inline-block; padding: 8px 24px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">
                            Đăng Nhập Ngay
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Đã đăng nhập: nạp trang tương ứng -->
                    <?php
                    switch ($admin_page) {
                        case 'upload':
                            include 'upload.php';
                            break;
                        case 'home':
                        default:
                            include 'home.php';
                            break;
                    }
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <table class="color-grid">
            <tr>
                <td style="background-color: blue;"></td>
                <td style="background-color: red;"></td>
                <td style="background-color: magenta;"></td>
            </tr>
            <tr>
                <td style="background-color: yellow;"></td>
                <td style="background-color: lime;"></td>
                <td style="background-color: gray;"></td>
            </tr>
            <tr>
                <td style="background-color: skyblue;"></td>
                <td style="background-color: lightgray;"></td>
                <td style="background-color: orangered;"></td>
            </tr>
        </table>
    </footer>
</div>
</body>
</html>
