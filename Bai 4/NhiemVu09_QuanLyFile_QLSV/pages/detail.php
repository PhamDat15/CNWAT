<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 9: DETAIL.PHP
// ========================================================
$file_path = __DIR__ . '/../student.txt';
$id = $_GET['id'] ?? '';
$student = null;

if (file_exists($file_path)) {
    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode('|', trim($line));
        if (isset($parts[0]) && $parts[0] == $id) {
            $student = [
                'id' => $parts[0],
                'ten' => $parts[1],
                'ngaysinh' => $parts[2],
                'diachi' => $parts[3],
                'anh' => $parts[4],
                'lop' => $parts[5]
            ];
            break;
        }
    }
}
?>

<h3>Chi Tiết Sinh Viên</h3>
<p style="color: #64748b; font-size: 13px; margin: 8px 0 15px 0;">Xem thông tin đầy đủ và ảnh chân dung lớn của sinh viên.</p>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 25px; max-width: 600px;">
    <?php if ($student): ?>
        <div style="display: flex; gap: 30px; align-items: center;">
            <div style="text-align: center;">
                <img src="uploads/<?php echo htmlspecialchars($student['anh']); ?>" alt="Ảnh lớn" style="width: 140px; height: 140px; object-fit: cover; border-radius: 8px; border: 2px solid #3b82f6; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" onerror="this.src='images/avatar.jpg'">
                <p style="margin-top: 8px; font-size: 12px; color: #64748b;">Ảnh hồ sơ</p>
            </div>
            <div style="flex: 1; line-height: 2;">
                <h4 style="color: #1e40af; font-size: 18px; margin-bottom: 8px;"><?php echo htmlspecialchars($student['ten']); ?></h4>
                <p><strong>Mã SV (ID):</strong> <?php echo htmlspecialchars($student['id']); ?></p>
                <p><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($student['ngaysinh']); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($student['diachi']); ?></p>
                <p><strong>Lớp học:</strong> <span style="background: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 4px; font-weight: bold;"><?php echo htmlspecialchars($student['lop']); ?></span></p>
            </div>
        </div>

        <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid #e2e8f0; display: flex; gap: 10px;">
            <a href="index.php?page=edit&id=<?php echo urlencode($student['id']); ?>" style="padding: 6px 16px; background: #059669; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">Chỉnh sửa thông tin</a>
            <a href="index.php?page=list" style="padding: 6px 16px; background: #64748b; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">&larr; Quay lại danh sách</a>
        </div>
    <?php else: ?>
        <p style="color: red;">Không tìm thấy thông tin sinh viên tương ứng!</p>
        <a href="index.php?page=list">&larr; Quay lại danh sách</a>
    <?php endif; ?>
</div>
