<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 5: ADMIN UPLOAD
// ========================================================

$msg = "";
$upload_dir = __DIR__ . "/../uploads/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_POST['btnUpload'])) {
    if (isset($_FILES['file1']) && !empty($_FILES['file1']['name'])) {
        $folder = "../uploads/";
        $name = $_FILES["file1"]["name"];
        $path = $folder . basename($name);
        $tmp = $_FILES["file1"]["tmp_name"];

        if (move_uploaded_file($tmp, $upload_dir . basename($name))) {
            $msg = "<p style='color: #15803d; background: #dcfce7; padding: 10px; border-radius: 4px; font-weight: bold;'>Upload file thành công: " . htmlspecialchars($name) . "</p>";
        } else {
            $msg = "<p style='color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 4px;'>Lỗi: Không thể lưu file tải lên!</p>";
        }
    } else {
        $msg = "<p style='color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 4px;'>Vui lòng chọn một file hợp lệ!</p>";
    }
}
?>

<div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px;">
    <h3 style="color: #1e40af; margin-bottom: 18px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">
        Trang Upload Files (Dành cho Administrator)
    </h3>

    <?php echo $msg; ?>

    <form method="POST" action="index.php?page=upload" enctype="multipart/form-data" style="margin-top: 15px;">
        <table border="0" cellpadding="8">
            <tr>
                <td style="font-weight: bold; width: 100px;">Chọn file:</td>
                <td>
                    <input type="file" name="file1" required style="border: 1px solid #cbd5e1; padding: 6px; border-radius: 4px;">
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 12px;">
                    <input type="reset" value="Reset" style="padding: 6px 16px; margin-right: 8px;">
                    <input type="submit" name="btnUpload" value="Upload" style="padding: 6px 20px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                </td>
            </tr>
        </table>
    </form>

    <div style="margin-top: 25px; padding-top: 15px; border-top: 1px dashed #cbd5e1;">
        <h4 style="color: #334155; margin-bottom: 10px;">Các tệp hiện có trong thư mục uploads:</h4>
        <ul style="padding-left: 20px; font-size: 13px; line-height: 1.8;">
            <?php
            $files = scandir($upload_dir);
            $found = false;
            foreach ($files as $f) {
                if ($f != '.' && $f != '..') {
                    $found = true;
                    echo "<li><a href='../uploads/" . urlencode($f) . "' download style='color: #2563eb; text-decoration: underline;'>" . htmlspecialchars($f) . "</a></li>";
                }
            }
            if (!$found) {
                echo "<li style='color: #94a3b8;'>Chưa có file nào trong thư mục uploads.</li>";
            }
            ?>
        </ul>
    </div>
</div>
