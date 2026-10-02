<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 11: LOP_LIST.PHP
// ========================================================
include 'connect.php';

// Xử lý Xóa nếu có tham số ?delete_id=...
if (isset($conn) && $conn && isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $sql_del = "DELETE FROM LOP WHERE MALOP = '$id'";
    if (mysqli_query($conn, $sql_del)) {
        echo "<script>alert('Xóa thành công!'); window.location.href='lop_list.php';</script>";
        exit();
    } else {
        echo "<script>alert('Lỗi: Không thể xóa (có thể do ràng buộc khóa ngoại với bảng HOSO)!');</script>";
    }
}

include 'header.php';
include 'left.php';
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3 style="color: #1e40af; margin: 0;">DANH SÁCH LỚP HỌC (TABLE LOP)</h3>
        <a href="lop_form.php" style="padding: 6px 14px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">+ Thêm Lớp Mới</a>
    </div>

    <?php if (!isset($conn) || !$conn): ?>
        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 6px; padding: 15px; margin-bottom: 15px; color: #92400e;">
            <p><strong>⚠️ Cảnh báo kết nối CSDL:</strong> Không thể kết nối tới MySQL Database <code>quanlyhocsinh</code>.</p>
            <p style="font-size: 13px; margin-top: 6px;">Vui lòng khởi động XAMPP MySQL và import file script <code>quanlyhocsinh.sql</code> để kiểm thử thực tế!</p>
        </div>
    <?php else: ?>
        <table class="db-table" border="1">
            <thead>
                <tr>
                    <th style="width: 100px;">Mã Lớp</th>
                    <th>Tên Lớp</th>
                    <th style="width: 100px;">Khóa Học</th>
                    <th>Giáo Viên Chủ Nhiệm (GVCN)</th>
                    <th style="width: 140px; text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM LOP ORDER BY MALOP ASC";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td style='font-weight: bold; color: #1e3a8a;'>" . htmlspecialchars($row["MALOP"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["TENLOP"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["KHOAHOC"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["GVCN"]) . "</td>";
                        echo "<td style='text-align: center;'>
                            <a href='lop_form.php?id=" . urlencode($row["MALOP"]) . "' style='color: #059669; font-weight: bold;'>Sửa</a> | 
                            <a href='lop_list.php?delete_id=" . urlencode($row["MALOP"]) . "' onclick='return confirm(\"Bạn chắc chắn muốn xóa lớp " . htmlspecialchars($row["MALOP"]) . "?\");' style='color: #dc2626; font-weight: bold;'>Xóa</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center; color: #94a3b8; padding: 15px;'>Chưa có dữ liệu lớp học trong bảng.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
