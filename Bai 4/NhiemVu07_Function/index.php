<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 7: FUNCTION
// ========================================================
$page = $_GET['page'] ?? 'ar1Chieu';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhiệm vụ 7: Thư viện Function | Phạm Tiến Đạt - AT200311</title>
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
                <li><a href="index.php"><strong>3.7. Thư viện Function (NV7)</strong></a></li>
                <li><a href="../NhiemVu08_DocGhiFile/index.php">3.8. Đọc ghi file (NV8)</a></li>
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
                <a href="index.php?page=ar1Chieu" class="<?php echo ($page == 'ar1Chieu') ? 'active' : ''; ?>">Ar1Chieu</a>
                <a href="index.php?page=matrix" class="<?php echo ($page == 'matrix') ? 'active' : ''; ?>">Matrix</a>
                <a href="index.php?page=demoMath" class="<?php echo ($page == 'demoMath') ? 'active' : ''; ?>">Demo Math</a>
            </div>

            <div class="content">
                <?php
                switch ($page) {
                    case 'matrix':
                        include 'pages/matrix.php';
                        break;
                    case 'demoMath':
                        include 'pages/demoMath.php';
                        break;
                    case 'ar1Chieu':
                    default:
                        include 'pages/ar1Chieu.php';
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
