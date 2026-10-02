<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 14: USEREDIT.PHP
// ========================================================
include 'header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user = null;

if (isset($conn) && $conn && $id > 0) {
    $r = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
    if ($r && $row = mysqli_fetch_assoc($r)) {
        $user = $row;
    }
}

if (!$user) {
    $user = [
        'id' => $id,
        'username' => 'u1',
        'password' => '123456',
        'fullname' => 'Nguyễn Quốc Bảo',
        'birthday' => '1998-04-12',
        'address' => 'Cầu Giấy, Hà Nội',
        'image' => '1.jpg'
    ];
}

// Xử lý cập nhật
if (isset($_POST['btnSave'])) {
    $fullname = trim($_POST['fullname'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $img_name = $user['image'];

    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $clean_img = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/images/' . $clean_img)) {
            $img_name = $clean_img;
        }
    }

    if (isset($conn) && $conn) {
        $f_safe = mysqli_real_escape_string($conn, $fullname);
        $b_safe = mysqli_real_escape_string($conn, $birthday);
        $a_safe = mysqli_real_escape_string($conn, $address);

        $sql = "UPDATE users SET fullname='$f_safe', birthday='$b_safe', address='$a_safe', image='$img_name' WHERE id=$id";
        mysqli_query($conn, $sql);
    }
    echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='userList.php';</script>";
    exit();
}
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 25px; max-width: 550px;">
    <h3 style="color: #1e40af; margin-bottom: 18px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">
        Sua thong tin user: <span style="color: #dc2626;"><?php echo htmlspecialchars($user['username']); ?></span>
    </h3>

    <form method="POST" action="" enctype="multipart/form-data">
        <table border="0" cellpadding="8" style="width: 100%;">
            <tr>
                <td style="width: 100px; font-weight: bold;">Username:</td>
                <td><input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly style="width: 100%; padding: 6px; background: #f1f5f9;"></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Fullname:</td>
                <td><input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Birthday:</td>
                <td><input type="date" name="birthday" value="<?php echo htmlspecialchars($user['birthday'] ?? '2000-01-01'); ?>" style="width: 100%; padding: 6px;"></td>
            </tr>
            <tr>
                <td style="font-weight: bold; vertical-align: top;">Address:</td>
                <td><textarea name="address" rows="3" style="width: 100%; padding: 6px;"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea></td>
            </tr>
            <tr>
                <td style="font-weight: bold; vertical-align: top;">Image:</td>
                <td>
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <img src="images/<?php echo htmlspecialchars($user['image'] ?? 'avatar.jpg'); ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;" onerror="this.src='images/avatar.jpg'">
                        <div>
                            <span style="font-size: 12px; color: #64748b;">(upload anh moi):</span>
                            <input type="file" name="image" style="display: block; margin-top: 4px; font-size: 12px;">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 15px;">
                    <input type="reset" value="Reset" style="padding: 6px 16px; margin-right: 8px;">
                    <input type="submit" name="btnSave" value="Save" style="padding: 6px 24px; background: #059669; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php include 'footer.php'; ?>
