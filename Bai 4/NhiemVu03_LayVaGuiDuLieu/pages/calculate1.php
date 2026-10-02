<h3>Trang Tính Toán 1 (Calculate1)</h3>
<p style="color: #475569; margin: 10px 0 15px 0; font-size: 14px;">
    Yêu cầu: Nhập 2 số nguyên a, b. Chọn phép tính (+, -, *, /) và nhấn nút Caculate để gửi lên server thực hiện.
</p>

<?php
$result = '';
$a_val = '';
$b_val = '';
$op_val = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a_val = isset($_POST['a']) ? $_POST['a'] : '';
    $b_val = isset($_POST['b']) ? $_POST['b'] : '';
    $operator = $_POST['operator'] ?? '';
    $op_val = $operator;

    if ($a_val !== '' && $b_val !== '') {
        $a = (float)$a_val;
        $b = (float)$b_val;

        switch ($operator) {
            case '+':
                $result = "$a + $b = " . ($a + $b);
                break;
            case '-':
                $result = "$a - $b = " . ($a - $b);
                break;
            case '*':
                $result = "$a * $b = " . ($a * $b);
                break;
            case '/':
                if ($b == 0) {
                    $result = "<span style='color: red;'>Không thể chia cho 0!</span>";
                } else {
                    $result = "$a / $b = " . round($a / $b, 4);
                }
                break;
            default:
                $result = "<span style='color: red;'>Vui lòng chọn phép tính!</span>";
        }
    } else {
        $result = "<span style='color: red;'>Vui lòng nhập đủ 2 số a và b!</span>";
    }
}
?>

<div style="max-width: 450px; background: white; padding: 20px; border: 1px solid #cbd5e1; border-radius: 8px;">
    <form method="POST" action="index.php?page=calculate1">
        <table border="0" cellpadding="8" style="width: 100%;">
            <tr>
                <td style="width: 110px; font-weight: bold;">Số a:</td>
                <td><input type="number" step="any" name="a" value="<?php echo htmlspecialchars($a_val); ?>" style="width: 100%;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Số b:</td>
                <td><input type="number" step="any" name="b" value="<?php echo htmlspecialchars($b_val); ?>" style="width: 100%;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Phép tính:</td>
                <td style="display: flex; gap: 15px; align-items: center; padding-top: 10px;">
                    <label style="cursor: pointer;"><input type="radio" name="operator" value="+" <?php if ($op_val == '+' || $op_val == '') echo 'checked'; ?>> + </label>
                    <label style="cursor: pointer;"><input type="radio" name="operator" value="-" <?php if ($op_val == '-') echo 'checked'; ?>> &minus; </label>
                    <label style="cursor: pointer;"><input type="radio" name="operator" value="*" <?php if ($op_val == '*') echo 'checked'; ?>> &times; </label>
                    <label style="cursor: pointer;"><input type="radio" name="operator" value="/" <?php if ($op_val == '/') echo 'checked'; ?>> &divide; </label>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 15px;">
                    <button type="submit" class="button" style="padding: 8px 24px;">Caculate</button>
                    <button type="button" onclick="window.location.href='index.php?page=calculate1'">Làm Mới</button>
                </td>
            </tr>
        </table>
    </form>

    <?php if ($result !== ''): ?>
    <div style="margin-top: 20px; padding: 12px; background: #f0fdf4; border: 1px solid #86efac; border-radius: 6px;">
        <strong style="color: #15803d;">Kết quả: </strong>
        <span style="font-size: 16px; font-weight: bold; color: #166534;"><?php echo $result; ?></span>
    </div>
    <?php endif; ?>
</div>
