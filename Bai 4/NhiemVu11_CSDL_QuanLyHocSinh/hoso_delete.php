<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 11: HOSO_DELETE.PHP
// ========================================================
include 'connect.php';

if (isset($conn) && $conn && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "DELETE FROM HOSO WHERE MAHS = '$id'";
    mysqli_query($conn, $sql);
}

header("Location: hoso_list.php");
exit();
?>
