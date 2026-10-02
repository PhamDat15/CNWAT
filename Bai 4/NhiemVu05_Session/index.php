<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 5: SESSION (END USER)
// ========================================================
session_start();
$page = $_GET['page'] ?? 'home';
$login_err = "";

// Xử lý login nếu submit form
if (isset($_POST['btnDangNhap'])) {
    $name = trim($_POST['txtUsername'] ?? '');
    $pass = trim($_POST['txtPassword'] ?? '');

    // Kiểm tra tài khoản admin/admin theo yêu cầu
    if ($name === "admin" && $pass === "admin") {
        $_SESSION['Username'] = $name;
        $_SESSION['Password'] = $pass;
        $_SESSION['LoginTime'] = date("d/m/Y H:i:s");
        header("Location: admin/index.php");
        exit();
    } else {
        $login_err = "Tên đăng nhập hoặc mật khẩu không đúng! (Gợi ý: admin / admin)";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhiệm vụ 5: Phiên Session | Phạm Tiến Đạt - AT200311</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <header>
        <div class="student-info">
            <p><strong>Thông tin của sinh viên:</strong></p>
            <p>Họ và tên: Phạm Tiến Đạt</p>
            <p>MSSV: AT200311</p>
            <p>Lớp: AT20A</p>
            <p>Ảnh:</p>
            <img src="images/avatar.jpg" alt="Avatar" width="80" height="80">
        </div>
        <div class="banner">
            <img src="images/banner.jpg" alt="Banner Bác Hồ">
        </div>
    </header>

    <div class="container">
        <!-- Sidebar Menu bài học chung -->
        <aside class="sidebar">
            <ul style="border: none;">
                <li><a href="../NhiemVu01_Template/index.php">3.1. Tạo template (NV1)</a></li>
                <li><a href="../NhiemVu02_SuDungTemplate/register.php">3.2. Sử dụng template (NV2)</a></li>
                <li><a href="../NhiemVu03_LayVaGuiDuLieu/index.php">3.3. Lấy và gửi dữ liệu (NV3)</a></li>
                <li><a href="../NhiemVu04_GetForm/index.php">3.4. GetForm (NV4)</a></li>
                <li><a href="index.php"><strong>3.5. Phiên Session (NV5)</strong></a></li>
                <li><a href="../NhiemVu06_Cookie/index.php">3.6. Cookie (NV6)</a></li>
                <li><a href="../NhiemVu07_Function/index.php">3.7. Thư viện Function (NV7)</a></li>
                <li><a href="../NhiemVu08_DocGhiFile/index.php">3.8. Đọc ghi file (NV8)</a></li>
                <li><a href="../NhiemVu09_QuanLyFile_QLSV/index.php">3.9. Quản lý file QLSV (NV9)</a></li>
                <li><a href="../NhiemVu10_DaNgonNgu/index.php">3.10. Website đa ngôn ngữ (NV10)</a></li>
                <li><a href="../NhiemVu11_CSDL_QuanLyHocSinh/lop_list.php">3.11. CSDL QLHS (NV11)</a></li>
                <li><a href="../NhiemVu12_TruyVanDuLieu/ListClass.php">3.12. Truy vấn dữ liệu (NV12)</a></li>
                <li><a href="../NhiemVu13_16_WebBanLaptop/index.php">3.13-16. Web bán laptop</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="menu">
                <a href="index.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>">Home</a>
                <a href="index.php?page=login" class="<?php echo ($page == 'login') ? 'active' : ''; ?>">Login</a>
                <?php if (isset($_SESSION['Username'])): ?>
                <a href="admin/index.php" style="background-color: #059669; color: white;">&rarr; Vào Admin Panel</a>
                <?php endif; ?>
            </div>

            <div class="content">
                <?php if ($page == 'login'): ?>
                    <div class="login-box">
                        <div class="login-title">Đăng Nhập Hệ Thống</div>
                        <?php if ($login_err): ?>
                            <div class="error-msg"><?php echo $login_err; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="index.php?page=login">
                            <div class="form-row">
                                <label>Username:</label>
                                <input type="text" name="txtUsername" value="admin" required>
                            </div>
                            <div class="form-row">
                                <label>Password:</label>
                                <input type="password" name="txtPassword" value="admin" required>
                            </div>
                            <div style="text-align: center; margin-top: 15px;">
                                <button type="reset" style="padding: 7px 18px; margin-right: 8px;">Nhập Lại</button>
                                <button type="submit" name="btnDangNhap" style="padding: 7px 22px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Đăng Nhập</button>
                            </div>
                            <div style="margin-top: 15px; font-size: 12px; color: #64748b; line-height: 1.6; background: #f8fafc; padding: 10px; border-radius: 4px;">
                                <strong>Chú ý theo yêu cầu đề bài:</strong><br>
                                - Tài khoản chuẩn: <code>admin</code> / <code>admin</code><br>
                                - Đăng nhập thành công sẽ lưu biến <code>$_SESSION['Username']</code> và chuyển hướng đến trang <code>admin/index.php</code>.
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <h3 style="color: #1e40af; margin-bottom: 12px;">Trang Chủ (End User - Home)</h3>
                        <p style="color: #334155; line-height: 1.6; margin-bottom: 15px;">
                            Chào mừng bạn đến với phân hệ <strong>End user</strong> của hệ thống quản lý phiên (Session).
                        </p>
                        <div style="padding: 15px; background: #f0fdf4; border-left: 4px solid #16a34a; border-radius: 4px;">
                            <p style="color: #166534; font-weight: bold;">Trạng thái phiên đăng nhập:</p>
                            <?php if (isset($_SESSION['Username'])): ?>
                                <p style="color: #15803d; margin-top: 6px;">
                                    Bạn đang đăng nhập với tư cách: <strong><?php echo htmlspecialchars($_SESSION['Username']); ?></strong>
                                </p>
                                <div style="margin-top: 12px;">
                                    <a href="admin/index.php" style="padding: 6px 16px; background: #16a34a; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">Đi tới Admin Dashboard</a>
                                    <a href="admin/logout.php" style="padding: 6px 16px; background: #dc2626; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; margin-left: 8px;">Đăng xuất</a>
                                </div>
                            <?php else: ?>
                                <p style="color: #64748b; margin-top: 6px;">Bạn hiện chưa đăng nhập vào hệ thống quản trị.</p>
                                <div style="margin-top: 12px;">
                                    <a href="index.php?page=login" style="padding: 6px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">Đăng nhập ngay</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
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
