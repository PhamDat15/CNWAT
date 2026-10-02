<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 8: ADDSTUDENT.PHP
// ========================================================
$file_path = __DIR__ . '/student.txt';
$msg = "";

if (isset($_POST['btnGhi'])) {
    $ten = trim($_POST['txtTen'] ?? '');
    $diachi = trim($_POST['txtDiaChi'] ?? '');
    $tuoi = trim($_POST['txtTuoi'] ?? '');

    if (!empty($ten) && !empty($diachi) && !empty($tuoi)) {
        // Ghi nối tiếp vào cuối file (append mode) mỗi trường trên 1 dòng
        $content = "\n" . $ten . "\n" . $diachi . "\n" . $tuoi;
        file_put_contents($file_path, $content, FILE_APPEND | LOCK_EX);
        
        $msg = "<p style='color: #15803d; background: #dcfce7; padding: 10px; border-radius: 4px; font-weight: bold;'>Đã ghi thêm sinh viên: " . htmlspecialchars($ten) . " vào file thành công!</p>";
    } else {
        $msg = "<p style='color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 4px;'>Vui lòng nhập đầy đủ Tên, Địa chỉ và Tuổi!</p>";
    }
}
?>

<h3>Thêm sinh viên mới (Ghi vào file student.txt)</h3>
<p style="color: #64748b; font-size: 13px; margin: 8px 0 15px 0;">Nhập thông tin sinh viên và nhấn nút "Ghi" để lưu trữ vào tệp văn bản.</p>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px; max-width: 480px;">
    <?php echo $msg; ?>

    <form method="POST" action="index.php?page=addStudent">
        <table border="0" cellpadding="8" style="width: 100%;">
            <tr>
                <td style="width: 90px; font-weight: bold;">Tên:</td>
                <td><input type="text" name="txtTen" style="width: 100%; padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 4px;" required placeholder="Ví dụ: Hoàng Văn An"></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Địa chỉ:</td>
                <td><input type="text" name="txtDiaChi" style="width: 100%; padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 4px;" required placeholder="Ví dụ: Hà Nội"></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tuổi:</td>
                <td><input type="number" name="txtTuoi" min="1" max="150" style="width: 100%; padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 4px;" required placeholder="Ví dụ: 21"></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 12px;">
                    <input type="reset" value="Nhập Lại" style="padding: 6px 16px; margin-right: 8px; cursor: pointer;">
                    <input type="submit" name="btnGhi" value="Ghi" style="padding: 6px 24px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                </td>
            </tr>
        </table>
    </form>

    <div style="margin-top: 20px; text-align: right;">
        <a href="index.php?page=listStudent" style="color: #2563eb; text-decoration: underline; font-weight: bold; font-size: 13px;">
            &rarr; Xem danh sách sinh viên hiện có
        </a>
    </div>
</div>
