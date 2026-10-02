<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL
// NHIỆM VỤ 2: SỬ DỤNG TEMPLATE - TRANG CALCULATE.PHP
// ========================================================
include 'header.php';
?>

<h3 style="color: #1e40af; margin-bottom: 18px;">Trang tính toán</h3>

<div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
    <?php
    // 1. Tính giai thừa của 10
    $n = 10;
    $giai_thua = 1;
    for ($i = 1; $i <= $n; $i++) {
        $giai_thua *= $i;
    }
    echo "<p style='margin-bottom: 10px;'><b>1. Giai thừa của 10 (10!):</b> <span style='color: #dc2626; font-size: 16px; font-weight: bold;'>$giai_thua</span></p>";

    // 2. Tính diện tích hình tròn và thể tích khối cầu (bán kính = 10)
    $r = 10;
    $pi = 3.14159265;
    $dien_tich = $pi * $r * $r;
    $the_tich = (4 / 3) * $pi * pow($r, 3);

    echo "<p style='margin-bottom: 10px;'><b>2. Diện tích hình tròn (r=10):</b> S = &pi; &times; r<sup>2</sup> = <span style='color: #059669; font-weight: bold;'>" . round($dien_tich, 2) . "</span> (đvdt)</p>";
    echo "<p style='margin-bottom: 10px;'><b>3. Thể tích khối cầu (r=10):</b> V = 4/3 &times; &pi; &times; r<sup>3</sup> = <span style='color: #7c3aed; font-weight: bold;'>" . round($the_tich, 2) . "</span> (đvtt)</p>";
    ?>
</div>

<hr style="margin: 20px 0; border: none; border-top: 1px dashed #ccc;">

<!-- Dòng chữ "Hello" chuyển động theo yêu cầu đề bài -->
<marquee direction="left" scrollamount="5" style="font-size: 24px; color: #dc2626; font-weight: bold; background: #fee2e2; padding: 10px; border-radius: 6px; border: 1px solid #fca5a5;">
    Hello! Chào mừng bạn đến với học phần Công Nghệ Web An Toàn - Học Viện Kỹ Thuật Mật Mã
</marquee>

<?php include 'footer.php'; ?>
