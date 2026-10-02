<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL
// NHIỆM VỤ 2: SỬ DỤNG TEMPLATE - TRANG RESULT_REGISTER.PHP
// ========================================================
include 'header.php';
?>

<h3 style="text-align:center; color: #1e40af; margin-bottom: 20px;">Kết quả đăng ký:</h3>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = isset($_POST['ten']) ? trim($_POST['ten']) : "";
    $diachi = isset($_POST['dia_chi']) ? trim($_POST['dia_chi']) : "";
    $nghe = isset($_POST['nghe']) ? trim($_POST['nghe']) : "";
    $ghichu = isset($_POST['ghi_chu']) ? trim($_POST['ghi_chu']) : "";

    echo "<div style='max-width: 450px; margin: 0 auto; background: #ffffff; border: 1px solid #d1d5db; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);'>";
    echo "<p style='margin-bottom: 12px;'><strong>Tên:</strong> " . htmlspecialchars($ten) . "</p>";
    echo "<p style='margin-bottom: 12px;'><strong>Địa chỉ:</strong> " . htmlspecialchars($diachi) . "</p>";
    echo "<p style='margin-bottom: 12px;'><strong>Nghề:</strong> " . htmlspecialchars($nghe) . "</p>";
    echo "<p style='margin-bottom: 12px;'><strong>Ghi chú:</strong> " . nl2br(htmlspecialchars($ghichu)) . "</p>";
    echo "<div style='text-align: center; margin-top: 20px;'>";
    echo "<a href='register.php' style='display: inline-block; padding: 6px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;'>&larr; Đăng ký người khác</a>";
    echo "</div>";
    echo "</div>";
} else {
    echo "<div style='text-align:center; padding: 30px; background: #fff; border-radius: 8px;'>";
    echo "<p style='color: #dc2626; font-size: 16px; margin-bottom: 15px;'>Chưa có dữ liệu đăng ký. Vui lòng nhập biểu mẫu từ trang Register!</p>";
    echo "<a href='register.php' style='color: #2563eb; text-decoration: underline; font-weight: bold;'>Đến trang Đăng ký</a>";
    echo "</div>";
}
?>

<?php include 'footer.php'; ?>
