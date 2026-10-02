<h3>Danh sách file đã upload</h3>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px; margin-top: 15px;">
<?php
$upload_dir = __DIR__ . "/../uploads/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$uploaded_count = 0;

if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {
    echo "<ul style='list-style: none; padding-left: 0;'>";
    foreach ($_FILES['files']['name'] as $i => $filename) {
        if (!empty($filename)) {
            $tmp = $_FILES['files']['tmp_name'][$i];
            $clean_filename = basename($filename);
            $destination = $upload_dir . $clean_filename;

            if (move_uploaded_file($tmp, $destination)) {
                $uploaded_count++;
                echo "<li style='padding: 8px 12px; margin-bottom: 8px; background: #f0fdf4; border: 1px solid #86efac; border-radius: 6px; display: flex; align-items: center; justify-content: space-between;'>";
                echo "<span>📄 <strong>File " . ($i + 1) . ":</strong> " . htmlspecialchars($clean_filename) . "</span>";
                echo "<a href='uploads/" . urlencode($clean_filename) . "' download style='padding: 4px 12px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;'>⬇ Download</a>";
                echo "</li>";
            }
        }
    }
    echo "</ul>";

    if ($uploaded_count === 0) {
        echo "<p style='color: #d97706;'>Bạn chưa chọn file nào để upload hoặc các file đã tải lên bị lỗi.</p>";
    } else {
        echo "<p style='color: #16a34a; font-weight: bold; margin-top: 15px;'>Đã upload thành công $uploaded_count file vào thư mục <code>uploads/</code>.</p>";
    }
} else {
    echo "<p style='color: #64748b;'>Chưa có file nào được gửi lên. Vui lòng quay lại form upload.</p>";
}
?>

    <div style="margin-top: 20px;">
        <a href="index.php?page=array2" style="color: #2563eb; text-decoration: underline; font-weight: bold;">&larr; Quay lại trang Upload nhiều file</a>
    </div>
</div>
