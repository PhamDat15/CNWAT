<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 9: EDIT.PHP
// ========================================================
$file_path = __DIR__ . '/../student.txt';
$upload_dir = __DIR__ . '/../uploads/';
$id = $_GET['id'] ?? '';
$msg = "";
$student = null;
$lines = [];

if (file_exists($file_path)) {
    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode('|', trim($line));
        if (isset($parts[0]) && $parts[0] == $id) {
            $student = [
                'id' => $parts[0],
                'ten' => $parts[1],
                'ngaysinh' => $parts[2],
                'diachi' => $parts[3],
                'anh' => $parts[4],
                'lop' => $parts[5]
            ];
            break;
        }
    }
}

// Xử lý cập nhật thông tin
if (isset($_POST['btnLuu']) && $student) {
    $fullname = trim($_POST['fullname'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $class = trim($_POST['class'] ?? '');
    $image_name = $student['anh'];

    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $filename = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename)) {
            $image_name = $filename;
        }
    }

    if (!empty($fullname) && !empty($address) && !empty($class)) {
        $new_lines = [];
        foreach ($lines as $line) {
            $parts = explode('|', trim($line));
            if (isset($parts[0]) && $parts[0] == $id) {
                $new_lines[] = "$id|$fullname|$birthday|$address|$image_name|$class";
            } else {
                $new_lines[] = trim($line);
            }
        }
        file_put_contents($file_path, implode("\n", $new_lines) . "\n", LOCK_EX);
        header("Location: index.php?page=list");
        exit();
    } else {
        $msg = "Vui lòng nhập đầy đủ các trường thông tin!";
    }
}
?>

<h3>Sửa Thông Tin Sinh Viên (Form Edit)</h3>
<p style="color: #64748b; font-size: 13px; margin: 8px 0 15px 0;">Cho phép hiển thị thông tin cũ và cập nhật thông tin mới vào file <code>student.txt</code>.</p>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px; max-width: 520px;">
    <?php if ($msg): ?>
        <p style="color: #dc2626; background: #fee2e2; padding: 8px; border-radius: 4px; margin-bottom: 12px;"><?php echo $msg; ?></p>
    <?php endif; ?>

    <?php if ($student): ?>
    <form method="POST" action="index.php?page=edit&id=<?php echo urlencode($id); ?>" enctype="multipart/form-data">
        <table border="0" cellpadding="8" style="width: 100%;">
            <tr>
                <td style="width: 100px; font-weight: bold;">Full name:</td>
                <td><input type="text" name="fullname" value="<?php echo htmlspecialchars($student['ten']); ?>" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Birthday:</td>
                <td><input type="date" name="birthday" value="<?php echo htmlspecialchars($student['ngaysinh']); ?>" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Address:</td>
                <td><input type="text" name="address" value="<?php echo htmlspecialchars($student['diachi']); ?>" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold; vertical-align: top;">Image:</td>
                <td>
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <img src="uploads/<?php echo htmlspecialchars($student['anh']); ?>" style="width: 55px; height: 55px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc;" onerror="this.src='images/avatar.jpg'">
                        <div>
                            <span style="font-size: 12px; color: #64748b;">(upload ảnh mới nếu muốn thay đổi)</span>
                            <input type="file" name="image" accept="image/*" style="display: block; margin-top: 4px; font-size: 12px;">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Class:</td>
                <td><input type="text" name="class" value="<?php echo htmlspecialchars($student['lop']); ?>" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 15px;">
                    <button type="button" onclick="window.location.href='index.php?page=list'" style="padding: 6px 16px; margin-right: 8px;">Hủy bỏ</button>
                    <input type="submit" name="btnLuu" value="Lưu Cập Nhật" style="padding: 6px 22px; background: #059669; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                </td>
            </tr>
        </table>
    </form>
    <?php else: ?>
        <p style="color: red;">Không tìm thấy sinh viên để chỉnh sửa!</p>
        <a href="index.php?page=list">&larr; Quay lại danh sách</a>
    <?php endif; ?>
</div>
