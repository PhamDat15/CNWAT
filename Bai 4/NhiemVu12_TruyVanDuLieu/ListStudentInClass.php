<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 12: LISTSTUDENTINCLASS.PHP
// ========================================================
require_once "libs/connectDB.php";

$classID = $_GET['classID'] ?? '';
$className = $classID;

if (isset($conn) && $conn && !empty($classID)) {
    $qClass = "SELECT ClassName FROM classes WHERE ID = '" . mysqli_real_escape_string($conn, $classID) . "'";
    $resC = mysqli_query($conn, $qClass);
    if ($resC && $rowC = mysqli_fetch_assoc($resC)) {
        $className = $rowC['ClassName'];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinh Viên Lớp <?php echo htmlspecialchars($classID); ?> | Phạm Tiến Đạt - AT200311</title>
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
                <li><a href="ListClass.php"><strong>3.12. Truy vấn dữ liệu (NV12)</strong></a></li>
                <li><a href="../NhiemVu13_16_WebBanLaptop/index.php">3.13-16. Web bán laptop</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3 style="color: #1e40af; margin: 0;">DANH SÁCH SINH VIÊN TRONG LỚP: <?php echo htmlspecialchars($classID); ?></h3>
                    <a href="ListClass.php" style="color: #2563eb; text-decoration: underline; font-weight: bold; font-size: 13px;">&larr; Xem các lớp khác</a>
                </div>
                <p style="color: #64748b; font-size: 13px; margin-bottom: 15px;">Tên lớp: <strong><?php echo htmlspecialchars($className); ?></strong></p>

                <div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px;">
                    <table border="1" style="width: 100%; border-collapse: collapse; border-color: #cbd5e1; text-align: left;">
                        <tr style="background: #f1f5f9; color: #334155;">
                            <th style="padding: 8px 12px; width: 60px; text-align: center;">Mã SV</th>
                            <th style="padding: 8px 12px;">Tên Sinh Viên</th>
                            <th style="padding: 8px 12px;">Địa Chỉ</th>
                            <th style="padding: 8px 12px; width: 90px; text-align: center;">Giới Tính</th>
                            <th style="padding: 8px 12px; width: 100px; text-align: center;">Thao Tác</th>
                        </tr>
                        <?php
                        if (isset($conn) && $conn) {
                            $query = "SELECT * FROM students WHERE ClassID = '" . mysqli_real_escape_string($conn, $classID) . "'";
                            $res = mysqli_query($conn, $query);
                            if ($res && mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<tr>";
                                    echo "<td style='padding: 8px 12px; text-align: center; font-weight: bold;'>" . htmlspecialchars($row["ID"]) . "</td>";
                                    echo "<td style='padding: 8px 12px; font-weight: bold; color: #1e293b;'>" . htmlspecialchars($row["StudentName"]) . "</td>";
                                    echo "<td style='padding: 8px 12px;'>" . htmlspecialchars($row["StudentAddress"]) . "</td>";
                                    echo "<td style='padding: 8px 12px; text-align: center;'>" . htmlspecialchars($row["StudentGender"]) . "</td>";
                                    echo "<td style='padding: 8px 12px; text-align: center;'><a href='studentDetail.php?studentID=" . urlencode($row["ID"]) . "' style='color: #2563eb; text-decoration: underline; font-weight: bold;'>Chi tiết</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' style='padding: 15px; text-align: center; color: #94a3b8;'>Không có sinh viên nào trong lớp này.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='padding: 15px; text-align: center; color: #dc2626;'>Chưa kết nối MySQL Database.</td></tr>";
                        }
                        ?>
                    </table>
                </div>
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
