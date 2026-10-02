<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 12: LISTCLASS.PHP
// ========================================================
require_once "libs/connectDB.php";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhiệm vụ 12: Truy Vấn Dữ Liệu 3 Cách | Phạm Tiến Đạt - AT200311</title>
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
                <li><a href="../NhiemVu08_DocGhiFile/index.php">3.8. Đọc ghi file (NV8)</a></li>
                <li><a href="../NhiemVu09_QuanLyFile_QLSV/index.php">3.9. Quản lý file QLSV (NV9)</a></li>
                <li><a href="../NhiemVu10_DaNgonNgu/index.php">3.10. Website đa ngôn ngữ (NV10)</a></li>
                <li><a href="../NhiemVu11_CSDL_QuanLyHocSinh/lop_list.php">3.11. CSDL QLHS (NV11)</a></li>
                <li><a href="ListClass.php"><strong>3.12. Truy vấn dữ liệu 3 cách (NV12)</strong></a></li>
                <li><a href="../NhiemVu13_16_WebBanLaptop/index.php">3.13-16. Web bán laptop</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content">
                <h3 style="color: #1e40af; margin-bottom: 15px;">Truy Vấn Dữ Liệu Các Lớp Bằng 3 Cách Duyệt Khác Nhau</h3>

                <?php if (!isset($conn) || !$conn): ?>
                    <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 6px; padding: 15px; margin-bottom: 20px; color: #92400e;">
                        <strong>⚠️ Chưa kết nối MySQL Database <code>school_db</code>:</strong>
                        <p style="font-size: 13px; margin-top: 6px;">Vui lòng mở phpMyAdmin và nạp file <code>database.sql</code> để kiểm thử trực tiếp.</p>
                    </div>
                <?php else: ?>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-top: 15px;">
                        
                        <!-- CÁCH 1: mysqli_fetch_row -->
                        <div style="background: white; border: 1px solid #cbd5e1; border-radius: 6px; padding: 15px;">
                            <h4 style="color: #2563eb; margin-bottom: 10px; font-size: 14px; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px;">
                                Danh sách các lớp (Cách 1: fetch_row)
                            </h4>
                            <ul style="list-style: none; padding-left: 0; line-height: 1.8;">
                                <?php
                                $query = "SELECT * FROM classes";
                                $result1 = mysqli_query($conn, $query);
                                if ($result1) {
                                    while ($row = mysqli_fetch_row($result1)) {
                                        $maLop = $row[0];
                                        $tenLop = $row[1];
                                        echo "<li><a href='ListStudentInClass.php?classID=" . urlencode($maLop) . "' style='color: #2563eb; text-decoration: underline; font-weight: bold;'>$maLop</a> - <span style='font-size: 12px; color: #64748b;'>$tenLop</span></li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>

                        <!-- CÁCH 2: mysqli_fetch_array -->
                        <div style="background: white; border: 1px solid #cbd5e1; border-radius: 6px; padding: 15px;">
                            <h4 style="color: #059669; margin-bottom: 10px; font-size: 14px; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px;">
                                Danh sách các lớp (Cách 2: fetch_array)
                            </h4>
                            <ul style="list-style: none; padding-left: 0; line-height: 1.8;">
                                <?php
                                $result2 = mysqli_query($conn, $query);
                                if ($result2) {
                                    while ($row = mysqli_fetch_array($result2)) {
                                        $maLop = $row[0];
                                        $tenLop = $row[1];
                                        echo "<li><a href='ListStudentInClass.php?classID=" . urlencode($maLop) . "' style='color: #059669; text-decoration: underline; font-weight: bold;'>$maLop</a> - <span style='font-size: 12px; color: #64748b;'>$tenLop</span></li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>

                        <!-- CÁCH 3: mysqli_fetch_assoc -->
                        <div style="background: white; border: 1px solid #cbd5e1; border-radius: 6px; padding: 15px;">
                            <h4 style="color: #7c3aed; margin-bottom: 10px; font-size: 14px; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px;">
                                Danh sách các lớp (Cách 3: fetch_assoc)
                            </h4>
                            <ul style="list-style: none; padding-left: 0; line-height: 1.8;">
                                <?php
                                $result3 = mysqli_query($conn, $query);
                                if ($result3) {
                                    while ($row = mysqli_fetch_assoc($result3)) {
                                        $maLop = $row["ID"];
                                        $tenLop = $row["ClassName"];
                                        echo "<li><a href='ListStudentInClass.php?classID=" . urlencode($maLop) . "' style='color: #7c3aed; text-decoration: underline; font-weight: bold;'>$maLop</a> - <span style='font-size: 12px; color: #64748b;'>$tenLop</span></li>";
                                    }
                                }
                                ?>
                            </ul>
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
<?php require_once "libs/closeConnectDB.php"; ?>
