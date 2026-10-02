<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 8: LISTSTUDENT.PHP
// ========================================================
$file_path = __DIR__ . '/student.txt';
$students = [];

if (file_exists($file_path)) {
    // Đọc tất cả các dòng trong file
    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $total_lines = count($lines);

    // Mỗi sinh viên chiếm đúng 3 dòng: Tên, Địa chỉ, Tuổi
    for ($i = 0; $i < $total_lines; $i += 3) {
        if (isset($lines[$i]) && isset($lines[$i+1]) && isset($lines[$i+2])) {
            $students[] = [
                'ten' => trim($lines[$i]),
                'diachi' => trim($lines[$i+1]),
                'tuoi' => trim($lines[$i+2])
            ];
        }
    }
}
?>

<h3>Danh sách sinh viên (Đọc từ file student.txt)</h3>
<p style="color: #64748b; font-size: 13px; margin: 8px 0 15px 0;">Đọc toàn bộ bản ghi theo cấu trúc 3 dòng/sinh viên và hiển thị ra bảng.</p>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px;">
    <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: bold; color: #1e40af;">Tổng số sinh viên: <?php echo count($students); ?></span>
        <a href="index.php?page=addStudent" style="padding: 6px 14px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">+ Thêm Sinh Viên Mới</a>
    </div>

    <table border="1" style="width: 100%; border-collapse: collapse; text-align: left; border-color: #cbd5e1;">
        <tr style="background: #f1f5f9; color: #334155;">
            <th style="padding: 8px 12px; width: 60px; text-align: center;">STT</th>
            <th style="padding: 8px 12px;">Tên</th>
            <th style="padding: 8px 12px;">Địa chỉ</th>
            <th style="padding: 8px 12px; width: 80px; text-align: center;">Tuổi</th>
        </tr>
        <?php if (!empty($students)): ?>
            <?php foreach ($students as $index => $sv): ?>
            <tr style="background: <?php echo ($index % 2 == 0) ? '#ffffff' : '#f8fafc'; ?>;">
                <td style="padding: 8px 12px; text-align: center; font-weight: bold;"><?php echo ($index + 1); ?></td>
                <td style="padding: 8px 12px; font-weight: bold; color: #1e293b;"><?php echo htmlspecialchars($sv['ten']); ?></td>
                <td style="padding: 8px 12px;"><?php echo htmlspecialchars($sv['diachi']); ?></td>
                <td style="padding: 8px 12px; text-align: center;"><?php echo htmlspecialchars($sv['tuoi']); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="padding: 20px; text-align: center; color: #94a3b8;">Chưa có dữ liệu sinh viên nào trong file!</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
