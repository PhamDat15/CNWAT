<h3>Trang DrawTable:</h3>

<p style="margin-top: 10px;"><b>Form vẽ bảng:</b></p>
<form method="POST" action="index.php?page=drawTable" style="margin-top: 10px;">
    <table border="0" cellpadding="6">
        <tr>
            <td style="font-weight: bold; width: 80px;">Số dòng:</td>
            <td>
                <input type="number" name="sodong" min="1" max="50" value="<?php echo isset($_POST['sodong']) ? htmlspecialchars($_POST['sodong']) : ''; ?>" placeholder="Ví dụ: 4" required>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Số cột:</td>
            <td>
                <input type="number" name="socot" min="1" max="50" value="<?php echo isset($_POST['socot']) ? htmlspecialchars($_POST['socot']) : ''; ?>" placeholder="Ví dụ: 4" required>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 10px;">
                <button type="reset">Nhập Lại</button>
                <button type="submit" name="btnVe">Vẽ</button>
            </td>
        </tr>
    </table>
    <p style="margin-top: 8px; color: #64748b; font-size: 13px;"><i>(Khi Click nút Vẽ thì mới vẽ bảng và hiển thị bên dưới)</i></p>
</form>

<hr style="margin: 20px 0; border: none; border-top: 1px dashed #cbd5e1;">

<?php
// Kiểm tra xem người dùng đã nhấn nút "Vẽ" chưa
if (isset($_POST['btnVe'])) {
    $rows = isset($_POST['sodong']) ? (int)$_POST['sodong'] : 0;
    $cols = isset($_POST['socot']) ? (int)$_POST['socot'] : 0;

    // Kiểm tra dữ liệu hợp lệ (phải > 0)
    if ($rows > 0 && $cols > 0) {
        echo "<h4 style='color: #1e3a8a; margin-bottom: 10px;'>Kết quả bảng " . $rows . " dòng &times; " . $cols . " cột:</h4>";
        echo "<table class='result-table' border='1' style='border-collapse: collapse; min-width: 300px;'>";

        // Vòng lặp ngoài: Tạo thẻ <tr> (Dòng)
        for ($i = 1; $i <= $rows; $i++) {
            echo "<tr>";
            // Vòng lặp trong: Tạo thẻ <td> (Cột)
            for ($j = 1; $j <= $cols; $j++) {
                // Hiển thị số thứ tự cột theo yêu cầu hình mẫu
                echo "<td style='padding: 8px 14px; text-align: center; border: 1px solid #94a3b8; background-color: " . ($i % 2 == 0 ? '#f8fafc' : '#ffffff') . ";'> $j </td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: #dc2626; font-weight: bold;'>Vui lòng nhập số dòng và số cột lớn hơn 0!</p>";
    }
}
?>
