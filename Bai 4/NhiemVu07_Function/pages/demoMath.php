<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 7: DEMOMATH.PHP
// ========================================================
require_once __DIR__ . '/../libs/math.php';
require_once __DIR__ . '/../libs/xuLyMangSo.php';
?>

<h3>Thực thi các hàm trong thư viện math.php & xuLyMangSo.php</h3>
<p style="color: #64748b; font-size: 13px; margin: 8px 0 15px 0;">Minh họa gọi hàm theo đúng mẫu tài liệu trang 72-74:</p>

<div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
    <h4 style="color: #1e40af; margin-bottom: 8px;">1. Gọi hàm vẽ bảng: <code>VeBang()</code></h4>
    <?php VeBang(); ?>

    <hr style="margin: 18px 0; border: none; border-top: 1px dashed #cbd5e1;">

    <h4 style="color: #1e40af; margin-bottom: 8px;">2. Gọi hàm tìm Max: <code>Max2(100, 10)</code></h4>
    <p>Kết quả Max2(100, 10) là: <strong style="color: #dc2626; font-size: 16px;"><?php echo Max2(100, 10); ?></strong></p>

    <hr style="margin: 18px 0; border: none; border-top: 1px dashed #cbd5e1;">

    <h4 style="color: #1e40af; margin-bottom: 8px;">3. Kiểm tra hàm đăng nhập: <code>CheckLogin("admin", "admin")</code></h4>
    <?php
    if (CheckLogin("admin", "admin")) {
        echo "<span style='color: #15803d; font-weight: bold; background: #dcfce7; padding: 4px 10px; border-radius: 4px;'>Đăng nhập thành công!</span>";
    } else {
        echo "<span style='color: #dc2626; font-weight: bold; background: #fee2e2; padding: 4px 10px; border-radius: 4px;'>Sai tên đăng nhập hoặc mật khẩu!</span>";
    }
    ?>

    <hr style="margin: 18px 0; border: none; border-top: 1px dashed #cbd5e1;">

    <h4 style="color: #1e40af; margin-bottom: 8px;">4. Gọi hàm truyền mảng: <code>$mang = [10, 2, 8, 6, 4, 1, 9]</code></h4>
    <?php
    $mang = [10, 2, 8, 6, 4, 1, 9];
    echo "<p>Mảng đầu vào: <code>[" . implode(', ', $mang) . "]</code></p>";
    echo "<p style='margin-top: 6px;'>Tổng theo cách 1 (for loop): <strong>" . TongDay1($mang) . "</strong></p>";
    echo "<p style='margin-top: 4px;'>Tổng theo cách 2 (foreach): <strong>" . TongDay2($mang) . "</strong></p>";
    ?>
</div>
