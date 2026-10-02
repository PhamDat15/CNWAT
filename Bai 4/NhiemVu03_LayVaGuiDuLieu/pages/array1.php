<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 3: ARRAY1 (MA TRẬN 3X3)
// ========================================================

// Khởi tạo biến
$m1 = array();
$m2 = array();
$tong = array();
$hieu = array();
$tich = array();
$msg = "";
$hien_thi_ket_qua = false;

// Thiết lập giá trị mặc định cho dễ kiểm tra
$default_m1 = [
    [1, 1, 1],
    [2, 2, 2],
    [3, 3, 3]
];
$default_m2 = [
    [0, 0, 0],
    [0, 0, 0],
    [0, 0, 0]
];

// Kiểm tra người dùng đã nhấn nút Tính chưa
if (isset($_POST['btnTinh'])) {
    $m1 = $_POST['m1'] ?? [];
    $m2 = $_POST['m2'] ?? [];
    $hien_thi_ket_qua = true;

    // Xử lý tính toán cho ma trận 3x3
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            // Kiểm tra dữ liệu nhập vào có phải số không
            if (!isset($m1[$i][$j]) || !isset($m2[$i][$j]) || !is_numeric($m1[$i][$j]) || !is_numeric($m2[$i][$j])) {
                $msg = "Vui lòng chỉ nhập số vào tất cả các ô của 2 ma trận!";
                $hien_thi_ket_qua = false;
                break 2; // Thoát khỏi cả 2 vòng lặp
            }

            $val1 = floatval($m1[$i][$j]);
            $val2 = floatval($m2[$i][$j]);

            // 1. Tính Tổng: Vị trí tương ứng cộng nhau
            $tong[$i][$j] = $val1 + $val2;

            // 2. Tính Hiệu: Vị trí tương ứng trừ nhau
            $hieu[$i][$j] = $val1 - $val2;

            // 3. Tính Tích: Dòng của M1 nhân với Cột của M2 (cần vòng lặp k)
            $tich[$i][$j] = 0;
            for ($k = 0; $k < 3; $k++) {
                $k_val1 = floatval($m1[$i][$k] ?? 0);
                $k_val2 = floatval($m2[$k][$j] ?? 0);
                $tich[$i][$j] += $k_val1 * $k_val2;
            }
        }
    }
} else {
    $m1 = $default_m1;
    $m2 = $default_m2;
}
?>

<h3>Sử dụng mảng để tính: hiệu, tổng, tích 2 ma trận</h3>
<p style="color: #64748b; font-size: 13px; margin-top: 5px;">Thao tác mảng 2 chiều 3x3. Nhấn nút "Tính" để xem kết quả.</p>

<?php if ($msg): ?>
    <p style="color: #dc2626; background: #fee2e2; padding: 8px 12px; border-radius: 4px; margin: 10px 0;"><?php echo $msg; ?></p>
<?php endif; ?>

<form method="POST" action="index.php?page=array1">
    <div class="matrix-container" style="display: flex; gap: 30px; margin-top: 15px;">
        <div class="matrix-input">
            <b style="color: #1e40af;">Nhập Ma trận 1</b>
            <table border="0" style="margin-top: 8px;">
                <?php
                for ($i = 0; $i < 3; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < 3; $j++) {
                        $val = isset($m1[$i][$j]) ? $m1[$i][$j] : "";
                        echo "<td><input type='text' name='m1[$i][$j]' value='$val' style='width: 50px; text-align: center; padding: 6px; border: 1px solid #cbd5e1; font-weight: bold;' required></td>";
                    }
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

        <div class="matrix-input">
            <b style="color: #059669;">Nhập Ma trận 2</b>
            <table border="0" style="margin-top: 8px;">
                <?php
                for ($i = 0; $i < 3; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < 3; $j++) {
                        $val = isset($m2[$i][$j]) ? $m2[$i][$j] : "";
                        echo "<td><input type='text' name='m2[$i][$j]' value='$val' style='width: 50px; text-align: center; padding: 6px; border: 1px solid #cbd5e1; font-weight: bold;' required></td>";
                    }
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <div style="margin-top: 15px;">
        <input type="button" value="Nhập Lại" onclick="window.location.href='index.php?page=array1'" style="padding: 7px 18px; cursor: pointer;">
        <input type="submit" name="btnTinh" value="Tính" style="padding: 7px 22px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
    </div>
</form>

<?php if ($hien_thi_ket_qua): ?>
<div class="result-box" style="margin-top: 25px; padding: 20px; background: white; border: 1px solid #e2e8f0; border-radius: 8px;">
    <h3 style="color: #dc2626; margin-bottom: 15px;">KẾT QUẢ:</h3>

    <?php
    if (!function_exists('hienThiMaTran')) {
        function hienThiMaTran($ten, $maTran, $color = "#1e3a8a") {
            echo "<div style='margin-bottom: 18px;'>";
            echo "<b style='color: $color;'>$ten:</b><br>";
            echo "<div style='font-family: monospace; font-size: 15px; line-height: 1.8; margin-top: 6px; display: inline-block; background: #f8fafc; padding: 8px 14px; border-radius: 4px; border: 1px solid #e2e8f0;'>";
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    echo sprintf("%6s", $maTran[$i][$j]) . "&nbsp;&nbsp;";
                }
                echo "<br>";
            }
            echo "</div>";
            echo "</div>";
        }
    }

    hienThiMaTran("Ma trận Tổng (M1 + M2)", $tong, "#2563eb");
    hienThiMaTran("Ma trận Hiệu (M1 - M2)", $hieu, "#059669");
    hienThiMaTran("Ma trận Tích (M1 &times; M2)", $tich, "#7c3aed");
    ?>
</div>
<?php endif; ?>
