<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 9: ADD.PHP
// ========================================================
$file_path = __DIR__ . '/../student.txt';
$upload_dir = __DIR__ . '/../uploads/';
$msg = "";

if (isset($_POST['btnLuu'])) {
    $fullname = trim($_POST['fullname'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $class = trim($_POST['class'] ?? '');
    $image_name = 'avatar.jpg';

    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $filename = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
            $image_name = $filename;
        }
    }

    if (!empty($fullname) && !empty($address) && !empty($class)) {
        // Tìm ID mới
        $new_id = 1;
        if (file_exists($file_path)) {
            $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $parts = explode('|', trim($line));
                if (isset($parts[0]) && intval($parts[0]) >= $new_id) {
                    $new_id = intval($parts[0]) + 1;
                }
            }
        }

        $new_line = "$new_id|$fullname|$birthday|$address|$image_name|$class\n";
        file_put_contents($file_path, $new_line, FILE_APPEND | LOCK_EX);

        header("Location: index.php?page=list");
        exit();
    } else {
        $msg = "Vui lòng nhập đầy đủ thông tin Họ tên, Địa chỉ và Lớp học!";
    }
}
?>

<h3>Thêm sinh viên mới (Form Add)</h3>
<p style="color: #64748b; font-size: 13px; margin: 8px 0 15px 0;">Nhập thông tin sinh viên và tải ảnh đại diện lên thư mục uploads.</p>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px; max-width: 500px;">
    <?php if ($msg): ?>
        <p style="color: #dc2626; background: #fee2e2; padding: 8px; border-radius: 4px; margin-bottom: 12px;"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=add" enctype="multipart/form-data">
        <table border="0" cellpadding="8" style="width: 100%;">
            <tr>
                <td style="width: 100px; font-weight: bold;">Full name:</td>
                <td><input type="text" name="fullname" style="width: 100%; padding: 6px;" placeholder="Ví dụ: Lê Thị Mai" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Birthday:</td>
                <td><input type="date" name="birthday" value="2002-01-01" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Address:</td>
                <td><input type="text" name="address" style="width: 100%; padding: 6px;" placeholder="Ví dụ: Hải Phòng" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Image:</td>
                <td><input type="file" name="image" accept="image/*" style="width: 100%; border: 1px solid #cbd5e1; padding: 4px; border-radius: 4px;"></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Class:</td>
                <td><input type="text" name="class" style="width: 100%; padding: 6px;" placeholder="Ví dụ: class1 hoặc AT20A" required></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 15px;">
                    <input type="reset" value="Nhập Lại" style="padding: 6px 16px; margin-right: 8px; cursor: pointer;">
                    <input type="submit" name="btnLuu" value="Lưu" style="padding: 6px 24px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                </td>
            </tr>
        </table>
    </form>
</div>
