<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 12: LIBS/CONNECTDB.PHP
// ========================================================

$host = "localhost";
$user = "root";
$pass = "";
$db   = "school_db";

// Sử dụng mysqli hiện đại tương thích các phiên bản PHP mới nhất
$conn = @mysqli_connect($host, $user, $pass, $db);

if ($conn) {
    mysqli_set_charset($conn, "utf8");
}
?>
