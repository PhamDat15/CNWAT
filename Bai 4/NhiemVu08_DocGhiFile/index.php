<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 8: MASTER INDEX.PHP
// ========================================================
$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhiệm vụ 8: Đọc Ghi File | Phạm Tiến Đạt - AT200311</title>
    <link rel="stylesheet" href="../NhiemVu03_LayVaGuiDuLieu/style.css">
</head>
<body>
<div class="wrapper">
    <header>
        <div class="student-info">
            <p><strong>Thông tin của sinh viên:</strong></p>
            <p>Họ và tên: Phạm Tiến Đạt</p>
            <p>MSSV: AT200311</p>
            <p>Lớp: AT20A</p>
            <img src="images/avatar.jpg" alt="Avatar" width="80" height="80">
        </div>
        <div class="banner">
            <img src="images/banner.jpg" alt="Banner Bác Hồ">
        </div>
    </header>

    <div class="container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <ul style="border: none;">
                <li><a href="../NhiemVu01_Template/index.php">3.1. Tạo template (NV1)</a></li>
                <li><a href="../NhiemVu02_SuDungTemplate/register.php">3.2. Sử dụng template (NV2)</a></li>
                <li><a href="../NhiemVu03_LayVaGuiDuLieu/index.php">3.3. Lấy và gửi dữ liệu (NV3)</a></li>
                <li><a href="../NhiemVu04_GetForm/index.php">3.4. GetForm (NV4)</a></li>
                <li><a href="../NhiemVu05_Session/index.php">3.5. Phiên Session (NV5)</a></li>
                <li><a href="../NhiemVu06_Cookie/index.php">3.6. Cookie (NV6)</a></li>
                <li><a href="../NhiemVu07_Function/index.php">3.7. Thư viện Function (NV7)</a></li>
                <li><a href="index.php"><strong>3.8. Đọc ghi file (NV8)</strong></a></li>
                <li><a href="../NhiemVu09_QuanLyFile_QLSV/index.php">3.9. Quản lý file QLSV (NV9)</a></li>
                <li><a href="../NhiemVu10_DaNgonNgu/index.php">3.10. Website đa ngôn ngữ (NV10)</a></li>
                <li><a href="../NhiemVu11_CSDL_QuanLyHocSinh/lop_list.php">3.11. CSDL QLHS (NV11)</a></li>
                <li><a href="../NhiemVu12_TruyVanDuLieu/ListClass.php">3.12. Truy vấn dữ liệu (NV12)</a></li>
                <li><a href="../NhiemVu13_16_WebBanLaptop/index.php">3.13-16. Web bán laptop</a></li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <div class="main-content">
            <div class="menu">
                <a href="index.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>">Home</a>
                <a href="index.php?page=listStudent" class="<?php echo ($page == 'listStudent') ? 'active' : ''; ?>">ListStudent</a>
                <a href="index.php?page=addStudent" class="<?php echo ($page == 'addStudent') ? 'active' : ''; ?>">Add Student</a>
            </div>

            <div class="content">
                <?php
                switch ($page) {
                    case 'listStudent':
                        include 'listStudent.php';
                        break;
                    case 'addStudent':
                        include 'addStudent.php';
                        break;
                    case 'home':
                    default:
                        echo "<div style='background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px;'>";
                        echo "<h3 style='color: #1e40af; margin-bottom: 12px;'>Trang Home - Quản lý sinh viên trong file student.txt</h3>";
                        echo "<p style='color: #475569; line-height: 1.6; margin-bottom: 15px;'>Hệ thống đọc và ghi cơ sở dữ liệu sinh viên trực tiếp vào tệp văn bản <code>student.txt</code> mà không cần cài đặt CSDL RDBMS phức tạp. Mỗi sinh viên được lưu trữ tuần tự gồm 3 dòng: Tên, Địa chỉ và Tuổi.</p>";
                        echo "<div style='margin-top: 15px; display: flex; gap: 10px;'>";
                        echo "<a href='index.php?page=listStudent' style='padding: 8px 18px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;'>Xem Danh Sách Sinh Viên &rarr;</a>";
                        echo "<a href='index.php?page=addStudent' style='padding: 8px 18px; background: #059669; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;'>+ Thêm Mới Sinh Viên</a>";
                        echo "</div>";
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
