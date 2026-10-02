<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL
// NHIỆM VỤ 3: LẤY VÀ GỬI DỮ LIỆU (CONTROLLER SWITCH-CASE)
// ========================================================

$page = $_GET['page'] ?? 'home'; // Trang mặc định là 'home'
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhiệm vụ 3: Lấy dữ liệu và gửi dữ liệu | Phạm Tiến Đạt - AT200311</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <!-- Header -->
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

    <!-- Thân trang -->
    <div class="container">
        <!-- Sidebar Menu bài học chung -->
        <aside class="sidebar">
            <ul>
                <li><a href="../NhiemVu01_Template/index.php">3.1. Tạo template (NV1)</a></li>
                <li><a href="../NhiemVu02_SuDungTemplate/register.php">3.2. Sử dụng template (NV2)</a></li>
                <li><a href="index.php?page=home"><strong>3.3. Lấy và gửi dữ liệu (NV3)</strong></a></li>
                <li><a href="../NhiemVu04_GetForm/index.php">3.4. GetForm (NV4)</a></li>
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

        <!-- Main Content -->
        <div class="main-content">
            <!-- Menu Nhiệm vụ 3 -->
            <div class="menu">
                <a href="index.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>">Home</a>
                <a href="index.php?page=drawTable" class="<?php echo ($page == 'drawTable') ? 'active' : ''; ?>">DrawTable</a>
                <a href="index.php?page=calculate1" class="<?php echo ($page == 'calculate1') ? 'active' : ''; ?>">Calculate1</a>
                <a href="index.php?page=calculate2" class="<?php echo ($page == 'calculate2') ? 'active' : ''; ?>">Calculate2</a>
                <a href="index.php?page=array1" class="<?php echo ($page == 'array1') ? 'active' : ''; ?>">Array1</a>
                <a href="index.php?page=array2" class="<?php echo ($page == 'array2') ? 'active' : ''; ?>">Array2</a>
            </div>

            <!-- Vùng nội dung nạp động theo switch-case -->
            <div class="content">
                <?php
                switch ($page) {
                    case 'drawTable':
                        include 'pages/drawTable.php';
                        break;
                    case 'calculate1':
                        include 'pages/calculate1.php';
                        break;
                    case 'calculate2':
                        include 'pages/calculate2.php';
                        break;
                    case 'array1':
                        include 'pages/array1.php';
                        break;
                    case 'array2':
                        include 'pages/array2.php';
                        break;
                    case 'uploadprocess':
                        include 'pages/uploadprocess.php';
                        break;
                    case 'home':
                    default:
                        include 'pages/home.php';
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer bảng 9 ô màu -->
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
