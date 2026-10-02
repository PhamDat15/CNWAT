<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 11: LOP_FORM.PHP
// ========================================================
include 'connect.php';

$id = "";
$tenlop = "";
$khoahoc = "";
$gvcn = "";
$is_edit = false;
$msg = "";

if (isset($conn) && $conn) {
    // Kiểm tra chế độ Sửa
    if (isset($_GET['id'])) {
        $is_edit = true;
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "SELECT * FROM LOP WHERE MALOP = '$id'";
        $result = mysqli_query($conn, $sql);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $tenlop = $row['TENLOP'];
            $khoahoc = $row['KHOAHOC'];
            $gvcn = $row['GVCN'];
        }
    }

    // Xử lý khi bấm nút Lưu
    if (isset($_POST['btnLuu'])) {
        $malop_new = mysqli_real_escape_string($conn, trim($_POST['malop']));
        $tenlop_new = mysqli_real_escape_string($conn, trim($_POST['tenlop']));
        $khoahoc_new = intval($_POST['khoahoc']);
        $gvcn_new = mysqli_real_escape_string($conn, trim($_POST['gvcn']));

        if ($is_edit) {
            // Cập nhật
            $sql = "UPDATE LOP SET TENLOP='$tenlop_new', KHOAHOC='$khoahoc_new', GVCN='$gvcn_new' WHERE MALOP='$id'";
        } else {
            // Thêm mới
            $sql = "INSERT INTO LOP (MALOP, TENLOP, KHOAHOC, GVCN) VALUES ('$malop_new', '$tenlop_new', '$khoahoc_new', '$gvcn_new')";
        }

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Thao tác thành công!'); window.location.href='lop_list.php';</script>";
            exit();
        } else {
            $msg = "Lỗi thực thi SQL: " . mysqli_error($conn);
        }
    }
}

include 'header.php';
include 'left.php';
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 25px; max-width: 500px;">
    <h3 style="color: #1e40af; margin-bottom: 18px;">
        <?php echo $is_edit ? "SỬA THÔNG TIN LỚP HỌC" : "THÊM LỚP HỌC MỚI"; ?>
    </h3>

    <?php if ($msg): ?>
        <p style="color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 4px; margin-bottom: 15px;"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <table border="0" cellpadding="8" style="width: 100%;">
            <tr>
                <td style="width: 110px; font-weight: bold;">Mã Lớp:</td>
                <td>
                    <input type="text" name="malop" value="<?php echo $is_edit ? htmlspecialchars($id) : ''; ?>" <?php echo $is_edit ? 'readonly style="background-color: #f1f5f9;"' : ''; ?> style="width: 100%; padding: 6px;" placeholder="Ví dụ: AT20C" required>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tên Lớp:</td>
                <td>
                    <input type="text" name="tenlop" value="<?php echo htmlspecialchars($tenlop); ?>" style="width: 100%; padding: 6px;" placeholder="Ví dụ: An Toàn Thông Tin 20C" required>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Khóa học:</td>
                <td>
                    <input type="number" name="khoahoc" value="<?php echo htmlspecialchars($khoahoc ?: '20'); ?>" style="width: 100%; padding: 6px;" required>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">GVCN:</td>
                <td>
                    <input type="text" name="gvcn" value="<?php echo htmlspecialchars($gvcn); ?>" style="width: 100%; padding: 6px;" placeholder="Ví dụ: Thầy Trần Văn E" required>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 15px;">
                    <button type="button" onclick="window.location.href='lop_list.php'" style="padding: 7px 16px; margin-right: 8px;">Hủy Bỏ</button>
                    <input type="submit" name="btnLuu" value="Lưu Dữ Liệu" style="padding: 7px 22px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php include 'footer.php'; ?>
