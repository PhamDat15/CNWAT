<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL
// NHIỆM VỤ 4: GETFORM - MASTER PAGE INDEX.PHP
// ========================================================

$page = $_GET['page'] ?? 'register';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhiệm vụ 4: GetForm | Phạm Tiến Đạt - AT200311</title>
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
        <aside class="sidebar">
            <ul>
                <li><a href="../NhiemVu01_Template/index.php">3.1. Tạo template (NV1)</a></li>
                <li><a href="../NhiemVu02_SuDungTemplate/register.php">3.2. Sử dụng template (NV2)</a></li>
                <li><a href="../NhiemVu03_LayVaGuiDuLieu/index.php">3.3. Lấy và gửi dữ liệu (NV3)</a></li>
                <li><a href="index.php?page=register"><strong>3.4. GetForm đa dạng (NV4)</strong></a></li>
                <li><a href="../NhiemVu05_Session/index.php">3.5. Phiên Session (NV5)</a></li>
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

        <div class="main-content">
            <div class="menu">
                <a href="index.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>">Home</a>
                <a href="index.php?page=register" class="<?php echo ($page == 'register' || $page == 'registerProcess') ? 'active' : ''; ?>">Register</a>
                <a href="index.php?page=contact1Page" class="<?php echo ($page == 'contact1Page') ? 'active' : ''; ?>">Contact1Page</a>
            </div>

            <div class="content">
                <?php
                switch ($page) {
                    case 'register':
                        include 'register.php';
                        break;
                    case 'registerProcess':
                        include 'registerProcess.php';
                        break;
                    case 'contact1Page':
                        include 'contact1Page.php';
                        break;
                    case 'home':
                    default:
                        echo "<div style='padding: 20px; background: white; border-radius: 8px;'>";
                        echo "<h3 style='color: #1e40af;'>Nhiệm vụ 4: Thu thập dữ liệu Form đa dạng</h3>";
                        echo "<p style='margin-top: 10px; line-height: 1.6;'>Minh họa cách lấy giá trị từ tất cả các điều khiển HTML Form thông dụng: Text, Password, Radio button, Checkbox mảng, Dropdown Select list, Textarea và Checkbox đơn.</p>";
                        echo "<div style='margin-top: 15px;'><a href='index.php?page=register' style='padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;'>Bắt đầu Thử nghiệm Register Form</a></div>";
                        echo "</div>";
                        break;
                }
                ?>
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
