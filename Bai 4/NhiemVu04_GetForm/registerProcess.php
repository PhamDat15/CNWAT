<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 4: REGISTER PROCESS
// ========================================================

if (isset($_POST["btnRegister"])) {
    // 1. Textbox and TextArea
    $name = $_POST["txtUsername"] ?? '';
    $pass = $_POST["txtPassword"] ?? '';
    $note = $_POST["taNote"] ?? '';

    // 2. CheckBox đơn (Marriage Status)
    $marriageStatus = isset($_POST["chkMariageStatus"]) ? "Da ket hon" : "Chua ket hon";

    // 3. CheckBox List (Programming Languages)
    $lang = "";
    if (isset($_POST["chkLang"]) && is_array($_POST["chkLang"])) {
        $arSendedLang = $_POST["chkLang"];
        foreach ($arSendedLang as $item) {
            $lang .= htmlspecialchars($item) . ", &nbsp;";
        }
        $lang = rtrim($lang, ", &nbsp;");
    } else {
        $lang = "Khong chon ngon ngu nao";
    }

    // 4. RadioButton List (Gender & Skill)
    $gender = $_POST["radGender"] ?? 'Chua xac dinh';
    $skill = $_POST["radSkill"] ?? 'Chua xac dinh';

    // 5. Select List (Address)
    $address = $_POST["lstAddress"] ?? 'Chua chon dia chi';
?>

<div class="form-title">Kết Quả Đăng Ký (Register Process)</div>
<table class="data-table" cellpadding="0" cellspacing="0" style="max-width: 550px;">
    <tr>
        <td colspan="2" style="text-align: center; background: #e0f2fe; color: #0369a1; font-weight: bold;">
            Thông Tin Nhận Được Từ Client
        </td>
    </tr>
    <tr>
        <td>Username:</td>
        <td><strong><?php echo htmlspecialchars($name); ?></strong></td>
    </tr>
    <tr>
        <td>Password:</td>
        <td><code><?php echo htmlspecialchars($pass); ?></code></td>
    </tr>
    <tr>
        <td>Gender:</td>
        <td><?php echo htmlspecialchars($gender); ?></td>
    </tr>
    <tr>
        <td>Address:</td>
        <td><?php echo htmlspecialchars($address); ?></td>
    </tr>
    <tr>
        <td>Enable Programming Language:</td>
        <td><span style="color: #2563eb; font-weight: bold;"><?php echo $lang; ?></span></td>
    </tr>
    <tr>
        <td>Skill:</td>
        <td><span style="color: #059669; font-weight: bold;"><?php echo htmlspecialchars($skill); ?></span></td>
    </tr>
    <tr>
        <td>Note:</td>
        <td><?php echo nl2br(htmlspecialchars($note)); ?></td>
    </tr>
    <tr>
        <td>Marriage Status:</td>
        <td>
            <span style="padding: 2px 8px; border-radius: 4px; font-weight: bold; <?php echo ($marriageStatus == 'Da ket hon') ? 'background: #dcfce7; color: #15803d;' : 'background: #f1f5f9; color: #475569;'; ?>">
                <?php echo htmlspecialchars($marriageStatus); ?>
            </span>
        </td>
    </tr>
</table>

<div style="text-align: center; margin-top: 20px;">
    <a href="index.php?page=register" style="padding: 7px 18px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
        &larr; Đăng ký lại
    </a>
</div>

<?php
} else {
    echo "<p style='text-align: center; color: red;'>Vui lòng submit dữ liệu từ trang <a href='index.php?page=register'>Register</a>!</p>";
}
?>
