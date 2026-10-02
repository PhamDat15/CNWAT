<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 14: USERDETAIL.PHP
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
        'fullname' => 'Nguyễn Quốc Bảo',
        'birthday' => '1998-04-12',
        'address' => 'Cầu Giấy, Hà Nội',
        'image' => '1.jpg'
    ];
}
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 25px; max-width: 580px;">
    <h3 style="color: #1e40af; margin-bottom: 18px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">
        Thong tin chi tiet nguoi dung: <span style="color: #dc2626;"><?php echo htmlspecialchars($user['username']); ?></span>
    </h3>

    <div style="display: flex; gap: 25px; align-items: center;">
        <img src="images/<?php echo htmlspecialchars($user['image'] ?? 'avatar.jpg'); ?>" style="width: 130px; height: 130px; object-fit: cover; border-radius: 8px; border: 2px solid #3b82f6;" onerror="this.src='images/avatar.jpg'">
        <div style="line-height: 2; font-size: 14px;">
            <p><strong>Fullname:</strong> <span style="font-size: 16px; color: #1e3a8a; font-weight: bold;"><?php echo htmlspecialchars($user['fullname']); ?></span></p>
            <p><strong>Birthday:</strong> <?php echo htmlspecialchars($user['birthday'] ?? 'Chưa rõ'); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address'] ?? 'Chưa rõ'); ?></p>
        </div>
    </div>

    <div style="margin-top: 25px; border-top: 1px solid #e2e8f0; padding-top: 15px; display: flex; gap: 10px;">
        <a href="userEdit.php?id=<?php echo $user['id']; ?>" style="padding: 6px 16px; background: #059669; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">Chỉnh sửa</a>
        <a href="userList.php" style="padding: 6px 16px; background: #64748b; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">&larr; Về danh sách</a>
    </div>
</div>

<?php include 'footer.php'; ?>
