<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 9: DELETE.PHP
// ========================================================
$file_path = __DIR__ . '/../student.txt';
$id = $_GET['id'] ?? '';

if (!empty($id) && file_exists($file_path)) {
    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $new_lines = [];
    foreach ($lines as $line) {
        $parts = explode('|', trim($line));
        if (isset($parts[0]) && $parts[0] == $id) {
            // Bỏ qua bản ghi cần xóa
            continue;
        }
        $new_lines[] = trim($line);
    }
    file_put_contents($file_path, implode("\n", $new_lines) . "\n", LOCK_EX);
}

header("Location: index.php?page=list");
exit();
?>
