<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 11: HOSO_LIST.PHP
// ========================================================
include 'connect.php';
include 'header.php';
include 'left.php';

// Cấu hình phân trang theo đúng yêu cầu đề bài: "10 bản ghi / trang"
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$start = ($page - 1) * $limit;

$total_records = 0;
$total_pages = 1;
$students = [];

if (isset($conn) && $conn) {
    // 1. Tính tổng số bản ghi
    $sql_total = "SELECT count(MAHS) as total FROM HOSO";
    $result_total = mysqli_query($conn, $sql_total);
    if ($result_total) {
        $row_total = mysqli_fetch_assoc($result_total);
        $total_records = $row_total['total'];
        $total_pages = max(1, ceil($total_records / $limit));
    }

    // 2. Lấy danh sách học sinh theo phân trang
    $sql = "SELECT * FROM HOSO ORDER BY MAHS ASC LIMIT $start, $limit";
    $result = mysqli_query($conn, $sql);
}
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3 style="color: #1e40af; margin: 0;">DANH SÁCH HỒ SƠ HỌC SINH (TABLE HOSO - PHÂN TRANG)</h3>
        <a href="hoso_form.php" style="padding: 6px 14px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">+ Thêm Học Sinh</a>
    </div>

    <?php if (!isset($conn) || !$conn): ?>
        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 6px; padding: 15px; margin-bottom: 15px; color: #92400e;">
            <p><strong>⚠️ Cảnh báo kết nối CSDL:</strong> Không thể kết nối tới MySQL Database <code>quanlyhocsinh</code>.</p>
            <p style="font-size: 13px; margin-top: 6px;">Vui lòng import file SQL <code>quanlyhocsinh.sql</code> vào phpMyAdmin/MySQL để kiểm thử.</p>
        </div>
    <?php else: ?>
        <table class="db-table" border="1">
            <thead>
                <tr>
                    <th style="width: 80px;">Mã HS</th>
                    <th>Họ Tên</th>
                    <th style="width: 95px;">Ngày Sinh</th>
                    <th>Địa Chỉ</th>
                    <th style="width: 80px;">Lớp</th>
                    <th style="width: 130px; text-align: center;">Điểm (T/L/H)</th>
                    <th style="width: 110px; text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td style='font-weight: bold; color: #1e3a8a;'>" . htmlspecialchars($row["MAHS"]) . "</td>";
                        echo "<td><strong>" . htmlspecialchars($row["HOTEN"]) . "</strong></td>";
                        echo "<td>" . htmlspecialchars($row["NGAYSINH"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["DIACHI"]) . "</td>";
                        echo "<td><span style='background: #e0f2fe; color: #0284c7; padding: 2px 6px; border-radius: 4px; font-weight: bold;'>" . htmlspecialchars($row["LOP"]) . "</span></td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . htmlspecialchars($row["DIEMTOAN"]) . " - " . htmlspecialchars($row["DIEMLY"]) . " - " . htmlspecialchars($row["DIEMHOA"]) . "</td>";
                        echo "<td style='text-align: center;'>
                            <a href='hoso_form.php?id=" . urlencode($row["MAHS"]) . "' style='color: #059669; font-weight: bold;'>Sửa</a> | 
                            <a href='hoso_delete.php?id=" . urlencode($row["MAHS"]) . "' onclick='return confirm(\"Bạn chắc chắn muốn xóa học sinh " . htmlspecialchars($row["HOTEN"]) . "?\");' style='color: #dc2626; font-weight: bold;'>Xóa</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align: center; color: #94a3b8; padding: 15px;'>Chưa có dữ liệu hồ sơ học sinh.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Thanh Phân Trang theo yêu cầu -->
        <div class="pagination">
            <span style="line-height: 28px; margin-right: 8px; font-size: 13px; color: #64748b;">
                Tổng số bản ghi: <strong><?php echo $total_records; ?></strong> &bull; Trang:
            </span>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="hoso_list.php?page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                    [<?php echo $i; ?>]
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
