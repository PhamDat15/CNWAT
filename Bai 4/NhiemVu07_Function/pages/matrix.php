<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 7: MATRIX.PHP
// ========================================================
require_once __DIR__ . '/../libs/xuLyMatran.php';

$m1 = $_POST['m1'] ?? [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];
$m2 = $_POST['m2'] ?? [
    [9, 8, 7],
    [6, 5, 4],
    [3, 2, 1]
];

$hien_thi = false;
$tong = [];
$tich = [];
$max1 = 0;
$min1 = 0;
$cheoChinh1 = 0;
$cheoPhu1 = 0;

if (isset($_POST['btnTinh'])) {
    $hien_thi = true;
    $tong = tinhMatranTong($m1, $m2);
    $tich = tinhMatranTich($m1, $m2);
    $max1 = maxMatran($m1);
    $min1 = minMatran($m1);
    $cheoChinh1 = tongTrenCheoChinh($m1);
    $cheoPhu1 = tongTrenCheoPhu($m1);
}
?>

<h3>Thao tác ma trận sử dụng thư viện hàm xuLyMatran.php</h3>
<p style="color: #64748b; font-size: 13px; margin-top: 5px;">Thực hiện tính Tổng, Tích và các phép toán giải tích trên ma trận vuông 3x3.</p>

<form method="POST" action="index.php?page=matrix">
    <div style="display: flex; gap: 30px; margin-top: 15px; flex-wrap: wrap;">
        <div>
            <b style="color: #1e40af;">Ma trận A (3x3):</b>
            <table border="0" style="margin-top: 8px;">
                <?php for ($i = 0; $i < 3; $i++): ?>
                <tr>
                    <?php for ($j = 0; $j < 3; $j++): ?>
                    <td><input type="number" step="any" name="m1[<?php echo $i; ?>][<?php echo $j; ?>]" value="<?php echo $m1[$i][$j]; ?>" style="width: 48px; text-align: center; padding: 5px; font-weight: bold; border: 1px solid #cbd5e1;" required></td>
                    <?php endfor; ?>
                </tr>
                <?php endfor; ?>
            </table>
        </div>

        <div>
            <b style="color: #059669;">Ma trận B (3x3):</b>
            <table border="0" style="margin-top: 8px;">
                <?php for ($i = 0; $i < 3; $i++): ?>
                <tr>
                    <?php for ($j = 0; $j < 3; $j++): ?>
                    <td><input type="number" step="any" name="m2[<?php echo $i; ?>][<?php echo $j; ?>]" value="<?php echo $m2[$i][$j]; ?>" style="width: 48px; text-align: center; padding: 5px; font-weight: bold; border: 1px solid #cbd5e1;" required></td>
                    <?php endfor; ?>
                </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>

    <div style="margin-top: 18px;">
        <input type="button" value="Nhập Lại" onclick="window.location.href='index.php?page=matrix'" style="padding: 7px 18px; cursor: pointer;">
        <input type="submit" name="btnTinh" value="Tính Toán Hàm Ma Trận" style="padding: 7px 22px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
    </div>
</form>

<?php if ($hien_thi): ?>
<div style="margin-top: 25px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
    <h4 style="color: #dc2626; margin-bottom: 15px;">KẾT QUẢ TÍNH TOÁN BẰNG THƯ VIỆN HÀM:</h4>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="background: #f8fafc; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0;">
            <b style="color: #2563eb;">Ma trận Tổng (A + B):</b>
            <div style="font-family: monospace; font-size: 15px; margin-top: 8px; line-height: 1.8;">
                <?php
                for ($i = 0; $i < 3; $i++) {
                    for ($j = 0; $j < 3; $j++) {
                        echo sprintf("%6s", $tong[$i][$j]) . "&nbsp;";
                    }
                    echo "<br>";
                }
                ?>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0;">
            <b style="color: #7c3aed;">Ma trận Tích (A &times; B):</b>
            <div style="font-family: monospace; font-size: 15px; margin-top: 8px; line-height: 1.8;">
                <?php
                for ($i = 0; $i < 3; $i++) {
                    for ($j = 0; $j < 3; $j++) {
                        echo sprintf("%6s", $tich[$i][$j]) . "&nbsp;";
                    }
                    echo "<br>";
                }
                ?>
            </div>
        </div>
    </div>

    <div style="margin-top: 15px; background: #eff6ff; padding: 12px 16px; border-radius: 6px; border: 1px solid #bfdbfe; font-size: 13px; line-height: 1.8;">
        <strong>Phân tích Ma trận A:</strong><br>
        - Max(A) = <strong><?php echo $max1; ?></strong> | Min(A) = <strong><?php echo $min1; ?></strong><br>
        - Tổng trên đường chéo chính = <strong><?php echo $cheoChinh1; ?></strong><br>
        - Tổng trên đường chéo phụ = <strong><?php echo $cheoPhu1; ?></strong>
    </div>
</div>
<?php endif; ?>
