<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 12: LIBS/CLOSECONNECTDB.PHP
// ========================================================

if (isset($conn) && $conn) {
    mysqli_close($conn);
}
?>
