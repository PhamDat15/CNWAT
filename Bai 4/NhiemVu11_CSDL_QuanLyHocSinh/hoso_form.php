<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 11: HOSO_FORM.PHP
// ========================================================
include 'connect.php';

$id = "";
$hoten = "";
$ngaysinh = "2000-01-01";
$diachi = "";
$malop = "";
$dtoan = "";
$dly = "";
$dhoa = "";
$is_edit = false;
$msg = "";

if (isset($conn) && $conn) {
    // 1. Kiểm tra chế độ Sửa
    if (isset($_GET['id'])) {
        $is_edit = true;
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "SELECT * FROM HOSO WHERE MAHS = '$id'";
        $rs = mysqli_query($conn, $sql);
        if ($rs && $row = mysqli_fetch_assoc($rs)) {
            $hoten = $row['HOTEN'];
            $ngaysinh = $row['NGAYSINH'];
            $diachi = $row['DIACHI'];
            $malop = $row['LOP'];
            $dtoan = $row['DIEMTOAN'];
            $dly = $row['DIEMLY'];
            $dhoa = $row['DIEMHOA'];
        }
    }

    // 2. Lấy danh sách lớp cho dropdown select (chống lỗi khóa ngoại)
    $list_lop = [];
    $rs_lop = mysqli_query($conn, "SELECT MALOP, TENLOP FROM LOP ORDER BY MALOP ASC");
    if ($rs_lop) {
        while ($r = mysqli_fetch_assoc($rs_lop)) {
            $list_lop[] = $r;
        }
    }

    // 3. Xử lý khi nhấn nút Lưu
    if (isset($_POST['btnLuu'])) {
        $mahs_new = mysqli_real_escape_string($conn, trim($_POST['mahs']));
        $hoten_new = mysqli_real_escape_string($conn, trim($_POST['hoten']));
        $ngaysinh_new = mysqli_real_escape_string($conn, trim($_POST['ngaysinh']));
        $diachi_new = mysqli_real_escape_string($conn, trim($_POST['diachi']));
        $malop_new = mysqli_real_escape_string($conn, trim($_POST['malop']));
        $dtoan_new = floatval($_POST['dtoan']);
        $dly_new = floatval($_POST['dly']);
        $dhoa_new = floatval($_POST['dhoa']);

        if ($is_edit) {
            $sql = "UPDATE HOSO SET 
                        HOTEN='$hoten_new', 
                        NGAYSINH='$ngaysinh_new', 
                        DIACHI='$diachi_new', 
                        LOP='$malop_new', 
                        DIEMTOAN=$dtoan_new, 
                        DIEMLY=$dly_new, 
                        DIEMHOA=$dhoa_new 
                    WHERE MAHS='$id'";
        } else {
            $sql = "INSERT INTO HOSO (MAHS, HOTEN, NGAYSINH, DIACHI, LOP, DIEMTOAN, DIEMLY, DIEMHOA) 
                    VALUES ('$mahs_new', '$hoten_new', '$ngaysinh_new', '$diachi_new', '$malop_new', $dtoan_new, $dly_new, $dhoa_new)";
        }

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Lưu hồ sơ thành công!'); window.location.href='hoso_list.php';</script>";
            exit();
        } else {
            $msg = "Lỗi thực thi SQL: " . mysqli_error($conn);
        }
    }
}

include 'header.php';
include 'left.php';
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 25px; max-width: 550px;">
    <h3 style="color: #1e40af; margin-bottom: 18px;">
        <?php echo $is_edit ? "SỬA HỒ SƠ HỌC SINH" : "THÊM HỒ SƠ HỌC SINH MỚI"; ?>
    </h3>

    <?php if ($msg): ?>
        <p style="color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 4px; margin-bottom: 15px;"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <table border="0" cellpadding="8" style="width: 100%;">
            <tr>
                <td style="width: 120px; font-weight: bold;">Mã Học Sinh:</td>
                <td>
                    <input type="text" name="mahs" value="<?php echo $is_edit ? htmlspecialchars($id) : ''; ?>" <?php echo $is_edit ? 'readonly style="background-color: #f1f5f9;"' : ''; ?> style="width: 100%; padding: 6px;" placeholder="Ví dụ: HS15" required>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Họ và Tên:</td>
                <td>
                    <input type="text" name="hoten" value="<?php echo htmlspecialchars($hoten); ?>" style="width: 100%; padding: 6px;" placeholder="Ví dụ: Nguyễn Văn Nam" required>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Ngày Sinh:</td>
                <td>
                    <input type="date" name="ngaysinh" value="<?php echo htmlspecialchars($ngaysinh); ?>" style="width: 100%; padding: 6px;" required>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Địa Chỉ:</td>
                <td>
                    <input type="text" name="diachi" value="<?php echo htmlspecialchars($diachi); ?>" style="width: 100%; padding: 6px;" placeholder="Ví dụ: Hà Nội" required>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Lớp:</td>
                <td>
                    <!-- Dùng select box chọn từ bảng LOP tránh lỗi khóa ngoại -->
                    <select name="malop" style="width: 100%; padding: 6px;" required>
                        <option value="">-- Chọn lớp học --</option>
                        <?php foreach ($list_lop as $lp): ?>
                            <option value="<?php echo htmlspecialchars($lp['MALOP']); ?>" <?php echo ($malop == $lp['MALOP']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($lp['MALOP']) . " - " . htmlspecialchars($lp['TENLOP']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Điểm Toán:</td>
                <td><input type="number" step="0.1" min="0" max="10" name="dtoan" value="<?php echo htmlspecialchars($dtoan); ?>" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Điểm Lý:</td>
                <td><input type="number" step="0.1" min="0" max="10" name="dly" value="<?php echo htmlspecialchars($dly); ?>" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Điểm Hóa:</td>
                <td><input type="number" step="0.1" min="0" max="10" name="dhoa" value="<?php echo htmlspecialchars($dhoa); ?>" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 15px;">
                    <button type="button" onclick="window.location.href='hoso_list.php'" style="padding: 7px 16px; margin-right: 8px;">Hủy Bỏ</button>
                    <input type="submit" name="btnLuu" value="Lưu Hồ Sơ" style="padding: 7px 22px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php include 'footer.php'; ?>
