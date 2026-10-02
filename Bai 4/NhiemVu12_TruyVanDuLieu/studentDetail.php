<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 12: STUDENTDETAIL.PHP
// ========================================================
require_once "libs/connectDB.php";

$studentID = $_GET['studentID'] ?? '';
$student = null;
$className = "";

if (isset($conn) && $conn && !empty($studentID)) {
    $q = "SELECT s.*, c.ClassName FROM students s LEFT JOIN classes c ON s.ClassID = c.ID WHERE s.ID = '" . mysqli_real_escape_string($conn, $studentID) . "'";
    $res = mysqli_query($conn, $q);
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $student = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Sinh Viên <?php echo htmlspecialchars($studentID); ?> | Phạm Tiến Đạt - AT200311</title>
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
        <aside class="sidebar">
            <ul style="border: none;">
                <li><a href="ListClass.php"><strong>3.12. Danh sách lớp học</strong></a></li>
                <?php if ($student): ?>
                <li><a href="ListStudentInClass.php?classID=<?php echo urlencode($student['ClassID']); ?>">&larr; Về lớp <?php echo htmlspecialchars($student['ClassID']); ?></a></li>
                <?php endif; ?>
            </ul>
        </aside>

        <div class="main-content">
            <div class="content">
                <h3 style="color: #1e40af; margin-bottom: 15px;">Thông Tin Chi Tiết Sinh Viên</h3>

                <?php if ($student): ?>
                    <div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 25px; max-width: 550px;">
                        <div style="display: flex; gap: 25px; align-items: center;">
                            <img src="images/<?php echo htmlspecialchars($student['StudentImage']); ?>" alt="Ảnh SV" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #3b82f6;" onerror="this.src='images/avatar.jpg'">
                            <div style="line-height: 2;">
                                <h4 style="color: #1e40af; font-size: 18px; margin: 0;"><?php echo htmlspecialchars($student['StudentName']); ?></h4>
                                <p><strong>Mã SV:</strong> <?php echo htmlspecialchars($student['ID']); ?></p>
                                <p><strong>Giới tính:</strong> <?php echo htmlspecialchars($student['StudentGender']); ?></p>
                                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($student['StudentAddress']); ?></p>
                                <p><strong>Lớp học:</strong> <span style="background: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 4px; font-weight: bold;"><?php echo htmlspecialchars($student['ClassID']) . " - " . htmlspecialchars($student['ClassName']); ?></span></p>
                            </div>
                        </div>

                        <div style="margin-top: 20px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                            <a href="ListStudentInClass.php?classID=<?php echo urlencode($student['ClassID']); ?>" style="padding: 6px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">&larr; Quay lại danh sách lớp</a>
                        </div>
                    </div>
                <?php else: ?>
                    <p style="color: red;">Không tìm thấy thông tin sinh viên!</p>
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
