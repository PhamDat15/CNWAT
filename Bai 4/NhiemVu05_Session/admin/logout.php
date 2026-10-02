<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 5: ADMIN LOGOUT
// ========================================================
session_start();

// Hủy các biến Session theo đúng mẫu trong tài liệu
unset($_SESSION["Username"]);
unset($_SESSION["Password"]);
session_destroy();

// Quay trở lại trang người dùng index.php
header("Location: ../index.php");
exit();
?>
