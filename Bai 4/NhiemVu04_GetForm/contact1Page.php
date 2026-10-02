<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 4: CONTACT 1 PAGE
// ========================================================

$is_submitted = false;
$username = "";
$gender = "";
$address = "";
$note = "";

if (isset($_POST['btnContact'])) {
    $is_submitted = true;
    $username = $_POST['txtUsername'] ?? '';
    $gender = $_POST['radGender'] ?? '';
    $address = $_POST['lstAddress'] ?? '';
    $note = $_POST['taNote'] ?? '';
}
?>

<div class="form-title">Form Liên Hệ (Xử lý trong 1 page)</div>

<?php if (!$is_submitted): ?>
<!-- Form liên hệ khi chưa submit -->
<form name="formContact" action="index.php?page=contact1Page" method="post">
    <table class="data-table" cellpadding="0" cellspacing="0" style="max-width: 500px;">
        <tr>
            <td>Username:</td>
            <td>
                <input name="txtUsername" type="text" id="txtUsername" size="30" placeholder="Nhập tên..." required>
            </td>
        </tr>
        <tr>
            <td>Gender:</td>
            <td>
                <label style="margin-right: 15px;"><input type="radio" name="radGender" value="Male" checked> Male</label>
                <label><input type="radio" name="radGender" value="Female"> Female</label>
            </td>
        </tr>
        <tr>
            <td>Address:</td>
            <td>
                <select name="lstAddress" size="4" id="lstAddress" style="width: 200px;" required>
                    <option value="Ha Noi" selected>Ha Noi</option>
                    <option value="TP. HCM">TP. HCM</option>
                    <option value="Hue">Hue</option>
                    <option value="Da Nang">Da Nang</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Note:</td>
            <td>
                <textarea name="taNote" cols="32" rows="3" placeholder="Nội dung liên hệ..."></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; padding: 15px 10px;">
                <input type="reset" value="Reset" style="margin-right: 10px;">
                <input type="submit" name="btnContact" value="Contact">
            </td>
        </tr>
    </table>
</form>

<?php else: ?>
<!-- Khi click vào nút Contact thì KẾT QUẢ hiện bên dưới và ẩn form liên hệ đi -->
<div style="max-width: 480px; margin: 20px auto; border: 2px solid #ef4444; border-radius: 8px; padding: 20px; background: white;">
    <h3 style="text-align: center; color: #1e3a8a; margin-bottom: 15px; border-bottom: 2px solid #ef4444; padding-bottom: 8px;">
        Thông tin liên hệ
    </h3>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px; font-weight: bold; width: 120px; color: #475569;">Username:</td>
            <td style="padding: 8px; font-weight: bold; color: #1e293b;"><?php echo htmlspecialchars($username); ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold; color: #475569;">Gender:</td>
            <td style="padding: 8px;"><?php echo ($gender == 'Male') ? 'Nam' : 'Nữ'; ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold; color: #475569;">Address:</td>
            <td style="padding: 8px;"><?php echo htmlspecialchars($address); ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold; color: #475569;">Note:</td>
            <td style="padding: 8px;"><?php echo nl2br(htmlspecialchars($note)); ?></td>
        </tr>
    </table>

    <div style="text-align: center; margin-top: 15px; border-top: 1px dashed #cbd5e1; padding-top: 12px;">
        <a href="index.php?page=contact1Page" style="padding: 6px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">
            &larr; Gửi liên hệ mới
        </a>
    </div>
</div>
<?php endif; ?>
