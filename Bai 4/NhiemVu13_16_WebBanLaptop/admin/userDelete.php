<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 14: USERDELETE.PHP
// ========================================================
require_once __DIR__ . '/../connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (isset($conn) && $conn && $id > 0) {
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
}

header("Location: userList.php");
exit();
?>
