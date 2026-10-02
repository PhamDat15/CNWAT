<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 3: CALCULATE2 (BẢNG ĐIỂM)
// ========================================================

$hovaten = "";
$lop = "";
$m1 = "";
$m2 = "";
$m3 = "";
$tongdiem = "";
$msg = ""; // Biến thông báo lỗi

// Kiểm tra xem người dùng có nhấn nút OK không
if (isset($_POST['ok'])) {
    // Lấy dữ liệu từ form
    $hovaten = trim($_POST['hovaten'] ?? '');
    $lop = trim($_POST['lop'] ?? '');
    $m1 = trim($_POST['m1'] ?? '');
    $m2 = trim($_POST['m2'] ?? '');
    $m3 = trim($_POST['m3'] ?? '');

    // 1. Kiểm tra rỗng (Validation: Required)
    if (empty($hovaten) || empty($lop) || $m1 === "" || $m2 === "" || $m3 === "") {
        $msg = "Vui lòng nhập đầy đủ thông tin!";
    }
    // 2. Kiểm tra dữ liệu số (Validation: Numeric)
    else if (!is_numeric($m1) || !is_numeric($m2) || !is_numeric($m3)) {
        $msg = "Điểm M1, M2, M3 phải là số!";
    }
    else {
        // 3. Tính tổng điểm
        $tongdiem = floatval($m1) + floatval($m2) + floatval($m3);
    }
}
?>

<h3>Trang Bảng Điểm (Calculate2)</h3>
<p style="color: #475569; font-size: 14px; margin: 8px 0 15px 0;">
    Yêu cầu: Các ô bắt buộc phải nhập; Điểm M1, M2, M3 phải ở dạng số. Nhấn OK tính tổng điểm; Nhấn CanCel xóa sạch dữ liệu.
</p>

<div class="form-container">
    <h3 style="text-align: center; color: #1e40af; margin-bottom: 15px;">Bảng Điểm Học Sinh</h3>

    <?php if ($msg): ?>
        <p class="error" style="color: #dc2626; background: #fee2e2; padding: 8px; border-radius: 4px; margin-bottom: 12px; font-size: 13px;">
            <?php echo $msg; ?>
        </p>
    <?php endif; ?>

    <form action="index.php?page=calculate2" method="POST">
        <div class="form-group" style="margin-bottom: 12px; display: flex; align-items: center;">
            <label style="width: 100px; font-weight: bold; font-size: 13px;">Họ và tên</label>
            <input type="text" name="hovaten" value="<?php echo htmlspecialchars($hovaten); ?>" style="flex: 1; padding: 6px;" required>
        </div>

        <div class="form-group" style="margin-bottom: 12px; display: flex; align-items: center;">
            <label style="width: 100px; font-weight: bold; font-size: 13px;">Lớp</label>
            <input type="text" name="lop" value="<?php echo htmlspecialchars($lop); ?>" style="flex: 1; padding: 6px;" required>
        </div>

        <div class="form-group" style="margin-bottom: 12px; display: flex; align-items: center;">
            <label style="width: 100px; font-weight: bold; font-size: 13px;">Điểm M1</label>
            <input type="text" name="m1" value="<?php echo htmlspecialchars($m1); ?>" style="flex: 1; padding: 6px;" placeholder="Ví dụ: 8.5" required>
        </div>

        <div class="form-group" style="margin-bottom: 12px; display: flex; align-items: center;">
            <label style="width: 100px; font-weight: bold; font-size: 13px;">Điểm M2</label>
            <input type="text" name="m2" value="<?php echo htmlspecialchars($m2); ?>" style="flex: 1; padding: 6px;" placeholder="Ví dụ: 7.0" required>
        </div>

        <div class="form-group" style="margin-bottom: 12px; display: flex; align-items: center;">
            <label style="width: 100px; font-weight: bold; font-size: 13px;">Điểm M3</label>
            <input type="text" name="m3" value="<?php echo htmlspecialchars($m3); ?>" style="flex: 1; padding: 6px;" placeholder="Ví dụ: 9.0" required>
        </div>

        <div class="form-group" style="margin-bottom: 15px; display: flex; align-items: center;">
            <label style="width: 100px; font-weight: bold; font-size: 13px;">Tổng điểm</label>
            <input type="text" name="tongdiem" value="<?php echo htmlspecialchars($tongdiem); ?>" readonly style="flex: 1; padding: 6px; background-color: #e9e9e9; font-weight: bold; color: #1e40af;">
        </div>

        <div class="buttons" style="text-align: center; margin-top: 15px;">
            <input type="submit" name="ok" value="OK" style="padding: 7px 24px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            <input type="button" value="CanCel" onclick="window.location.href='index.php?page=calculate2'" style="padding: 7px 20px; background: #94a3b8; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
        </div>
    </form>
</div>
