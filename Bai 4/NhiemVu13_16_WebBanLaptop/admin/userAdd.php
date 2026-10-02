<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 14: USERADD.PHP
// ========================================================
include 'header.php';

$msg = "";
if (isset($_POST['btnSave'])) {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');
    $fname = trim($_POST['fullname'] ?? '');
    $bday = trim($_POST['birthday'] ?? '');
    $addr = trim($_POST['address'] ?? '');
    $img_name = 'avatar.jpg';

    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $clean_img = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/images/' . $clean_img)) {
            $img_name = $clean_img;
        }
    }

    if (isset($conn) && $conn) {
        $u_safe = mysqli_real_escape_string($conn, $user);
        $p_safe = mysqli_real_escape_string($conn, $pass);
        $f_safe = mysqli_real_escape_string($conn, $fname);
        $b_safe = mysqli_real_escape_string($conn, $bday);
        $a_safe = mysqli_real_escape_string($conn, $addr);

        $sql = "INSERT INTO users (username, password, fullname, birthday, address, image) 
                VALUES ('$u_safe', '$p_safe', '$f_safe', '$b_safe', '$a_safe', '$img_name')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Thêm người dùng thành công!'); window.location.href='userList.php';</script>";
            exit();
        } else {
            $msg = "Lỗi: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Đã thêm người dùng thành công (demo mode)!'); window.location.href='userList.php';</script>";
        exit();
    }
}
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 25px; max-width: 550px;">
    <h3 style="color: #1e40af; margin-bottom: 18px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">
        Them nguoi dung moi (userAdd.php)
    </h3>

    <?php if ($msg): ?>
        <p style="color: red; margin-bottom: 10px;"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="POST" action="userAdd.php" enctype="multipart/form-data">
        <table border="0" cellpadding="8" style="width: 100%;">
            <tr>
                <td style="width: 100px; font-weight: bold;">Username:</td>
                <td><input type="text" name="username" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Password:</td>
                <td><input type="password" name="password" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Fullname:</td>
                <td><input type="text" name="fullname" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Birthday:</td>
                <td><input type="date" name="birthday" value="2000-01-01" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold; vertical-align: top;">Address:</td>
                <td><textarea name="address" rows="3" style="width: 100%; padding: 6px;"></textarea></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Image:</td>
                <td><input type="file" name="image" style="width: 100%; border: 1px solid #cbd5e1; padding: 4px; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 15px;">
                    <input type="reset" value="Reset" style="padding: 6px 16px; margin-right: 8px; cursor: pointer;">
                    <input type="submit" name="btnSave" value="Save" style="padding: 6px 24px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php include 'footer.php'; ?>
