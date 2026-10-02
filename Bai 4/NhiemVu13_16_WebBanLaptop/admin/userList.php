<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 14: USERLIST.PHP
// ========================================================
include 'header.php';

$users = [];
if (isset($conn) && $conn) {
    $r = mysqli_query($conn, "SELECT * FROM users ORDER BY id ASC");
    if ($r) {
        while ($row = mysqli_fetch_assoc($r)) {
            $users[] = $row;
        }
    }
}

// Dữ liệu mẫu dự phòng
if (empty($users)) {
    $users = [
        ['id' => 1, 'username' => 'admin', 'fullname' => 'Phạm Tiến Đạt', 'image' => 'avatar.jpg'],
        ['id' => 2, 'username' => 'u1', 'fullname' => 'Nguyễn Quốc Bảo', 'image' => '1.jpg'],
        ['id' => 3, 'username' => 'u2', 'fullname' => 'Phạm Hoàng Long', 'image' => '2.jpg'],
        ['id' => 5, 'username' => 'u3', 'fullname' => 'Trần Thủ Độ', 'image' => '3.jpg']
    ];
}
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #b91c1c; padding-bottom: 8px; margin-bottom: 15px;">
        <h3 style="color: #b91c1c; margin: 0; font-size: 16px;">👤 QUẢN LÝ NGƯỜI DÙNG (USERS LIST)</h3>
        <a href="userAdd.php" style="padding: 6px 14px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px;">Add new user</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 50px; text-align: center;">ID</th>
                <th>Fullname</th>
                <th style="width: 100px; text-align: center;">Image</th>
                <th style="width: 180px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
                <td style="text-align: center; font-weight: bold;"><?php echo $u['id']; ?></td>
                <td>
                    <strong style="color: #1e3a8a;"><?php echo htmlspecialchars($u['fullname']); ?></strong>
                    <div style="font-size: 12px; color: #64748b;">User: <?php echo htmlspecialchars($u['username']); ?></div>
                </td>
                <td style="text-align: center;">
                    <img src="images/<?php echo htmlspecialchars($u['image'] ?? 'avatar.jpg'); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;" onerror="this.src='images/avatar.jpg'">
                </td>
                <td style="text-align: center;">
                    <a href="userDetail.php?id=<?php echo $u['id']; ?>" style="color: #2563eb; text-decoration: underline; margin-right: 5px;">Chi tiet</a> | 
                    <a href="userDelete.php?id=<?php echo $u['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');" style="color: #dc2626; text-decoration: underline; margin: 0 5px;">Xoa</a> | 
                    <a href="userEdit.php?id=<?php echo $u['id']; ?>" style="color: #059669; text-decoration: underline; margin-left: 5px;">Sua</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
