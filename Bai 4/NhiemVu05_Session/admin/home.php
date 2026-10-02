<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 5: ADMIN HOME
// ========================================================
?>
<div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px;">
    <h3 style="color: #1e40af; margin-bottom: 18px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">
        Bảng Điều Khiển Quản Trị (Admin Dashboard)
    </h3>

    <div style="max-width: 480px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; padding: 18px; line-height: 2;">
        <p><strong>Tên đăng nhập:</strong> <span style="color: #2563eb; font-weight: bold;"><?php echo htmlspecialchars($_SESSION['Username'] ?? ''); ?></span></p>
        <p><strong>Mật khẩu:</strong> <span style="font-family: monospace; background: #e2e8f0; padding: 2px 8px; border-radius: 4px;"><?php echo htmlspecialchars($_SESSION['Password'] ?? ''); ?></span></p>
        <p><strong>Thời gian đăng nhập:</strong> <?php echo htmlspecialchars($_SESSION['LoginTime'] ?? 'Vừa xong'); ?></p>
        <p><strong>Quyền hạn:</strong> <span style="background: #dcfce7; color: #166534; font-weight: bold; padding: 2px 8px; border-radius: 4px;">Toàn quyền Quản Trị Viên (Administrator)</span></p>
    </div>

    <div style="margin-top: 25px; display: flex; gap: 12px;">
        <a href="index.php?page=upload" style="padding: 8px 18px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
            &uarr; Upload Tệp Lên Máy Chủ
        </a>
        <a href="logout.php" style="padding: 8px 18px; background: #ef4444; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
            Đăng Xuất Khỏi Phiên
        </a>
    </div>
</div>
