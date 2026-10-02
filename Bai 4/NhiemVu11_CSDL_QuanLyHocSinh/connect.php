<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 11: CONNECT.PHP
// ========================================================

$servername = "localhost";
$username = "root"; // Mặc định của XAMPP
$password = "";     // Mặc định để trống
$dbname = "quanlyhocsinh";

// Tạo kết nối
$conn = @mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
    // Thông báo lỗi nếu MySQL chưa bật
    $db_error = mysqli_connect_error();
} else {
    // Thiết lập font chữ tiếng Việt
    mysqli_set_charset($conn, 'UTF8');
}
?>
