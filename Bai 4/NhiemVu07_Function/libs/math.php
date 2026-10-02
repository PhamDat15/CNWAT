<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - THƯ VIỆN HÀM MATH & SYSTEM
// ========================================================

// 1. Hàm vẽ bảng mẫu 3 hàng 2 cột
function VeBang() {
    echo "<table width='450' border='1' style='border-collapse: collapse; margin: 10px 0; background: #e0f2fe; text-align: center;'>";
    echo "<tr><td style='padding: 8px;'>Hàng 1 - Cột 1</td><td style='padding: 8px;'>Hàng 1 - Cột 2</td></tr>";
    echo "<tr><td style='padding: 8px;'>Hàng 2 - Cột 1</td><td style='padding: 8px;'>Hàng 2 - Cột 2</td></tr>";
    echo "<tr><td style='padding: 8px;'>Hàng 3 - Cột 1</td><td style='padding: 8px;'>Hàng 3 - Cột 2</td></tr>";
    echo "</table>";
}

// 2. Hàm tìm số lớn hơn trong 2 số
function Max2($a, $b) {
    return ($a >= $b) ? $a : $b;
}

// 3. Hàm kiểm tra đăng nhập sử dụng băm md5 theo yêu cầu mẫu tài liệu
function CheckLogin($username, $password) {
    $hashPass = md5($password);
    $hashPassDung = md5("admin");

    if ($username === "admin" && $hashPass === $hashPassDung) {
        return true;
    } else {
        return false;
    }
}
?>
