<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 7: AR1CHIEU.PHP
// ========================================================
require_once __DIR__ . '/../libs/xuLyMangSo.php';

$str_input = $_POST['day_so'] ?? '3, 3, 3, 1, 3, 3, 5, 3, 3';
$hien_thi = false;
$mangSo = [];
$tong = 0;
$tb = 0;
$min = 0;
$max = 0;
$mangSort = [];
$mangDao = [];

if (isset($_POST['btnCalculate'])) {
    // Chuyển chuỗi nhập vào thành mảng số
    $raw_parts = preg_split('/[\s,]+/', trim($str_input));
    foreach ($raw_parts as $part) {
        if (is_numeric($part)) {
            $mangSo[] = floatval($part);
        }
    }

    if (!empty($mangSo)) {
        $hien_thi = true;
        $tong = TongDay1($mangSo);
        $tb = avgDay($mangSo);
        $min = minDay($mangSo);
        $max = maxDay($mangSo);
        $mangSort = sortDay($mangSo);
        $mangDao = daoNguocDay($mangSo);
    }
}
?>

<h3>Thao tác trên mảng 1 chiều</h3>
<p style="color: #475569; font-size: 14px; margin: 8px 0 15px 0;">
    Bài toán: Nhập vào chuỗi số (ngăn cách bởi dấu phẩy hoặc khoảng trắng): tính tổng các số, giá trị trung bình, tìm min, max, sắp xếp và đảo ngược dãy số bằng thư viện hàm <code>xuLyMangSo.php</code>.
</p>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px; max-width: 600px;">
    <form method="POST" action="index.php?page=ar1Chieu">
        <label style="font-weight: bold; display: block; margin-bottom: 6px;">Nhập chuỗi số:</label>
        <input type="text" name="day_so" value="<?php echo htmlspecialchars($str_input); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: bold;" required>
        
        <div style="margin-top: 15px;">
            <input type="button" value="Reset" onclick="window.location.href='index.php?page=ar1Chieu'" style="padding: 7px 18px; cursor: pointer;">
            <input type="submit" name="btnCalculate" value="Calculate" style="padding: 7px 22px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
        </div>
    </form>

    <?php if ($hien_thi): ?>
    <div style="margin-top: 25px; padding: 18px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;">
        <h4 style="color: #dc2626; margin-bottom: 12px;">KẾT QUẢ:</h4>
        <table style="width: 100%; border-collapse: collapse; line-height: 1.8;">
            <tr>
                <td style="width: 160px; font-weight: bold; color: #334155;">Dãy số ban đầu:</td>
                <td><code>[ <?php echo implode(', ', $mangSo); ?> ]</code></td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #334155;">Tổng các phần tử:</td>
                <td><strong style="color: #2563eb; font-size: 15px;"><?php echo $tong; ?></strong> (Kiểm tra cách 2: <?php echo TongDay2($mangSo); ?>)</td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #334155;">Trung bình cộng:</td>
                <td><strong style="color: #059669;"><?php echo $tb; ?></strong></td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #334155;">Giá trị nhỏ nhất (Min):</td>
                <td><strong style="color: #7c3aed;"><?php echo $min; ?></strong></td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #334155;">Giá trị lớn nhất (Max):</td>
                <td><strong style="color: #ea580c;"><?php echo $max; ?></strong></td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #334155;">Dãy số tăng dần:</td>
                <td>[ <?php echo implode(', ', $mangSort); ?> ]</td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #334155;">Dãy số đảo ngược:</td>
                <td>[ <?php echo implode(', ', $mangDao); ?> ]</td>
            </tr>
        </table>
    </div>
    <?php endif; ?>
</div>
