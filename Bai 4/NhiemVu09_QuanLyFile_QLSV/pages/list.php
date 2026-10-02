<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 9: LIST.PHP
// ========================================================
$file_path = __DIR__ . '/../student.txt';
$students = [];

if (file_exists($file_path)) {
    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode('|', trim($line));
        if (count($parts) >= 6) {
            $students[] = [
                'id' => $parts[0],
                'ten' => $parts[1],
                'ngaysinh' => $parts[2],
                'diachi' => $parts[3],
                'anh' => $parts[4],
                'lop' => $parts[5]
            ];
        }
    }
}
?>

<h3>Danh Sách Sinh Viên (Quản lý Data Flow bằng File)</h3>
<p style="color: #64748b; font-size: 13px; margin: 8px 0 15px 0;">Đầy đủ các thao tác: Xem danh sách, Thêm mới, Sửa thông tin, Chi tiết sinh viên và Xóa.</p>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px;">
    <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: bold; color: #1e40af;">Tổng số sinh viên: <?php echo count($students); ?></span>
        <a href="index.php?page=add" style="padding: 6px 14px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">+ Thêm Sinh Viên Mới</a>
    </div>

    <table border="1" style="width: 100%; border-collapse: collapse; border-color: #cbd5e1; text-align: left;">
        <tr style="background: #f1f5f9; color: #334155;">
            <th style="padding: 8px 10px; width: 50px; text-align: center;">STT</th>
            <th style="padding: 8px 10px;">Tên</th>
            <th style="padding: 8px 10px; width: 100px;">Ngày sinh</th>
            <th style="padding: 8px 10px;">Địa chỉ</th>
            <th style="padding: 8px 10px; width: 70px; text-align: center;">Ảnh</th>
            <th style="padding: 8px 10px; width: 80px;">Lớp</th>
            <th style="padding: 8px 10px; width: 160px; text-align: center;">Thao tác</th>
        </tr>
        <?php if (!empty($students)): ?>
            <?php foreach ($students as $index => $sv): ?>
            <tr style="background: <?php echo ($index % 2 == 0) ? '#ffffff' : '#f8fafc'; ?>;">
                <td style="padding: 8px 10px; text-align: center; font-weight: bold;"><?php echo ($index + 1); ?></td>
                <td style="padding: 8px 10px; font-weight: bold; color: #1e293b;"><?php echo htmlspecialchars($sv['ten']); ?></td>
                <td style="padding: 8px 10px;"><?php echo htmlspecialchars($sv['ngaysinh']); ?></td>
                <td style="padding: 8px 10px;"><?php echo htmlspecialchars($sv['diachi']); ?></td>
                <td style="padding: 4px 6px; text-align: center;">
                    <img src="uploads/<?php echo htmlspecialchars($sv['anh']); ?>" alt="Ảnh SV" style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;" onerror="this.src='images/avatar.jpg'">
                </td>
                <td style="padding: 8px 10px;"><?php echo htmlspecialchars($sv['lop']); ?></td>
                <td style="padding: 8px 10px; text-align: center;">
                    <a href="index.php?page=detail&id=<?php echo urlencode($sv['id']); ?>" style="color: #2563eb; text-decoration: underline; margin-right: 6px;">Detail</a> |
                    <a href="index.php?page=edit&id=<?php echo urlencode($sv['id']); ?>" style="color: #059669; text-decoration: underline; margin: 0 6px;">Edit</a> |
                    <a href="index.php?page=delete&id=<?php echo urlencode($sv['id']); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');" style="color: #dc2626; text-decoration: underline; margin-left: 6px;">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="padding: 20px; text-align: center; color: #94a3b8;">Không có bản ghi sinh viên nào.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
