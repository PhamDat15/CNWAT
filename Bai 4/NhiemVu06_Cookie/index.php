<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 6: COOKIE & SESSIONS
// ========================================================
session_start();
$page = $_GET['page'] ?? 'home';
$login_err = "";

// 1. Xử lý thêm Link ưa thích vào Cookie
if (isset($_POST['btnAddLink'])) {
    $title = trim($_POST['link_title'] ?? '');
    $url = trim($_POST['link_url'] ?? '');
    if (!empty($title) && !empty($url)) {
        $favorites = [];
        if (isset($_COOKIE['fav_links'])) {
            $favorites = json_decode($_COOKIE['fav_links'], true) ?? [];
        }
        $favorites[] = ['title' => $title, 'url' => $url];
        // Lưu Cookie 30 ngày
        setcookie('fav_links', json_encode($favorites), time() + 30 * 24 * 60 * 60, "/");
        header("Location: index.php?page=favorites");
        exit();
    }
}

// 2. Xử lý xóa danh sách Cookie favorites
if (isset($_GET['action']) && $_GET['action'] == 'clear_favs') {
    setcookie('fav_links', '', time() - 3600, "/");
    header("Location: index.php?page=favorites");
    exit();
}

// 3. Xử lý Đăng Nhập & Lưu Cookie
if (isset($_POST['btnDangNhap'])) {
    $name = trim($_POST['txtUsername'] ?? '');
    $pass = trim($_POST['txtPassword'] ?? '');

    if ($name === "admin" && $pass === "admin") {
        $_SESSION['Username'] = $name;
        $_SESSION['Password'] = $pass;

        // Lưu thông tin đăng nhập ra Cookies thời hạn 30 ngày theo đúng tài liệu
        setcookie("Username", $name, time() + 30 * 24 * 60 * 60, "/");
        setcookie("Password", $pass, time() + 30 * 24 * 60 * 60, "/");

        header("Location: index.php?page=admin_home");
        exit();
    } else {
        $login_err = "Sai tên đăng nhập hoặc mật khẩu! (Gợi ý: admin / admin)";
    }
}

// 4. Xử lý Logout & Xóa Cookies nếu chọn
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    unset($_SESSION['Username']);
    unset($_SESSION['Password']);
    session_destroy();
    header("Location: index.php?page=login");
    exit();
}

// Lấy cookie đã lưu nếu có
$cookie_user = $_COOKIE['Username'] ?? '';
$cookie_pass = $_COOKIE['Password'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhiệm vụ 6: Cơ chế Cookie | Phạm Tiến Đạt - AT200311</title>
    <link rel="stylesheet" href="../NhiemVu05_Session/style.css">
    <style>
        .cookie-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid #fde68a;
        }
        .fav-list {
            list-style: none;
            padding-left: 0;
            margin-top: 15px;
        }
        .fav-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 8px;
            border: 1px solid #e2e8f0;
        }
        .fav-item a {
            color: #2563eb;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <header>
        <div class="student-info">
            <p><strong>Thông tin của sinh viên:</strong></p>
            <p>Họ và tên: Phạm Tiến Đạt</p>
            <p>MSSV: AT200311</p>
            <p>Lớp: AT20A</p>
            <img src="images/avatar.jpg" alt="Avatar" width="80" height="80">
        </div>
        <div class="banner">
            <img src="images/banner.jpg" alt="Banner Bác Hồ">
        </div>
    </header>

    <div class="container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <ul style="border: none;">
                <li><a href="../NhiemVu01_Template/index.php">3.1. Tạo template (NV1)</a></li>
                <li><a href="../NhiemVu02_SuDungTemplate/register.php">3.2. Sử dụng template (NV2)</a></li>
                <li><a href="../NhiemVu03_LayVaGuiDuLieu/index.php">3.3. Lấy và gửi dữ liệu (NV3)</a></li>
                <li><a href="../NhiemVu04_GetForm/index.php">3.4. GetForm (NV4)</a></li>
                <li><a href="../NhiemVu05_Session/index.php">3.5. Phiên Session (NV5)</a></li>
                <li><a href="index.php"><strong>3.6. Cơ chế Cookie (NV6)</strong></a></li>
                <li><a href="../NhiemVu07_Function/index.php">3.7. Thư viện Function (NV7)</a></li>
                <li><a href="../NhiemVu08_DocGhiFile/index.php">3.8. Đọc ghi file (NV8)</a></li>
                <li><a href="../NhiemVu09_QuanLyFile_QLSV/index.php">3.9. Quản lý file QLSV (NV9)</a></li>
                <li><a href="../NhiemVu10_DaNgonNgu/index.php">3.10. Website đa ngôn ngữ (NV10)</a></li>
                <li><a href="../NhiemVu11_CSDL_QuanLyHocSinh/lop_list.php">3.11. CSDL QLHS (NV11)</a></li>
                <li><a href="../NhiemVu12_TruyVanDuLieu/ListClass.php">3.12. Truy vấn dữ liệu (NV12)</a></li>
                <li><a href="../NhiemVu13_16_WebBanLaptop/index.php">3.13-16. Web bán laptop</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="menu">
                <a href="index.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>">Home</a>
                <a href="index.php?page=login" class="<?php echo ($page == 'login') ? 'active' : ''; ?>">Login (Cookie)</a>
                <a href="index.php?page=favorites" class="<?php echo ($page == 'favorites') ? 'active' : ''; ?>">Favorite Links (Cookie)</a>
                <?php if (isset($_SESSION['Username'])): ?>
                    <a href="index.php?page=admin_home" class="<?php echo ($page == 'admin_home') ? 'active' : ''; ?>" style="background-color: #059669; color: white;">Admin Panel</a>
                <?php endif; ?>
            </div>

            <div class="content">
                <?php if ($page == 'login'): ?>
                    <!-- Form Đăng Nhập ghi nhớ Cookie -->
                    <div class="login-box" style="max-width: 480px;">
                        <div class="login-title">Đăng Nhập (Tự động ghi nhớ Cookie)</div>
                        
                        <?php if ($login_err): ?>
                            <div class="error-msg"><?php echo $login_err; ?></div>
                        <?php endif; ?>

                        <?php if ($cookie_user !== ''): ?>
                            <div style="background: #fefce8; border: 1px solid #fde047; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; color: #854d0e;">
                                🍪 <strong>Phát hiện Cookie hợp lệ:</strong> Thông tin tài khoản đã được tự động điền sẵn từ Cookies lưu trữ trên trình duyệt!
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?page=login">
                            <div class="form-row">
                                <label>Username:</label>
                                <input type="text" name="txtUsername" value="<?php echo htmlspecialchars($cookie_user ?: 'admin'); ?>" required>
                            </div>
                            <div class="form-row">
                                <label>Password:</label>
                                <input type="password" name="txtPassword" value="<?php echo htmlspecialchars($cookie_pass ?: 'admin'); ?>" required>
                            </div>
                            
                            <?php if ($cookie_user !== ''): ?>
                                <p style="font-size: 12px; color: #d97706; text-align: right; margin-bottom: 10px; font-style: italic;">
                                    username, password duoc lay tu Cookies
                                </p>
                            <?php endif; ?>

                            <div style="text-align: center; margin-top: 15px;">
                                <button type="reset" style="padding: 7px 18px; margin-right: 8px;">Nhập Lại</button>
                                <button type="submit" name="btnDangNhap" style="padding: 7px 24px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Đăng Nhập</button>
                            </div>

                            <div style="margin-top: 15px; font-size: 12px; color: #64748b; line-height: 1.6; background: #f8fafc; padding: 10px; border-radius: 4px;">
                                <strong>Cơ chế hoạt động Cookie:</strong><br>
                                - Cookie được lưu trên máy Client với thời hạn 30 ngày: <code>setcookie("Username", $name, time()+30*24*60*60)</code><br>
                                - Khi mở lại trình duyệt hoặc tải lại trang, PHP tự động đọc <code>$_COOKIE['Username']</code> để điền vào form.
                            </div>
                        </form>
                    </div>

                <?php elseif ($page == 'favorites'): ?>
                    <!-- Quản lý Web Link Favorites lưu trong Cookie -->
                    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <h3 style="color: #1e40af; margin-bottom: 12px;">Quản Lý Web Link Ưa Thích Bằng Cookie</h3>
                        <p style="color: #475569; font-size: 14px; margin-bottom: 20px;">
                            Hệ thống đọc và lưu danh sách liên kết yêu thích vào Cookie của trình duyệt. Mỗi lần tải trang, danh sách sẽ được phục hồi nguyên vẹn.
                        </p>

                        <!-- Form thêm link mới -->
                        <form method="POST" action="index.php?page=favorites" style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                            <h4 style="color: #334155; margin-bottom: 10px;">Thêm Liên Kết Ưa Thích Mới:</h4>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <input type="text" name="link_title" placeholder="Tiêu đề trang (ví dụ: KMA Portal)" required style="flex: 1; min-width: 180px; padding: 7px 10px; border: 1px solid #cbd5e1; border-radius: 4px;">
                                <input type="url" name="link_url" placeholder="Địa chỉ URL (ví dụ: https://actvn.edu.vn)" required style="flex: 2; min-width: 220px; padding: 7px 10px; border: 1px solid #cbd5e1; border-radius: 4px;">
                                <button type="submit" name="btnAddLink" style="padding: 7px 20px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">+ Thêm vào Cookie</button>
                            </div>
                        </form>

                        <!-- Danh sách link đọc từ Cookie -->
                        <h4 style="color: #334155; margin-bottom: 10px;">Danh Sách Liên Kết Hiện Có (Từ Cookie):</h4>
                        <?php
                        $favs = [];
                        if (isset($_COOKIE['fav_links'])) {
                            $favs = json_decode($_COOKIE['fav_links'], true) ?? [];
                        }

                        // Mặc định tạo vài link mẫu nếu chưa có
                        if (empty($favs)) {
                            $favs = [
                                ['title' => 'Học Viện Kỹ Thuật Mật Mã (KMA)', 'url' => 'https://actvn.edu.vn'],
                                ['title' => 'Tài Liệu PHP Manual', 'url' => 'https://www.php.net/manual/en/'],
                                ['title' => 'W3Schools PHP MySQL Tutorial', 'url' => 'https://www.w3schools.com/php/']
                            ];
                        }
                        ?>

                        <ul class="fav-list">
                            <?php foreach ($favs as $idx => $f): ?>
                                <li class="fav-item">
                                    <div>
                                        <strong><?php echo htmlspecialchars($f['title']); ?></strong>
                                        <div style="font-size: 12px; color: #64748b;"><?php echo htmlspecialchars($f['url']); ?></div>
                                    </div>
                                    <a href="<?php echo htmlspecialchars($f['url']); ?>" target="_blank" style="padding: 5px 12px; background: #e0f2fe; color: #0284c7; border-radius: 4px; text-decoration: none; font-size: 13px;">Truy Cập &rarr;</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div style="margin-top: 20px; text-align: right;">
                            <a href="index.php?page=favorites&action=clear_favs" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ Cookie liên kết?');" style="color: #dc2626; font-size: 13px; text-decoration: underline;">
                                🗑 Xóa toàn bộ Cookie Favorite Links
                            </a>
                        </div>
                    </div>

                <?php elseif ($page == 'admin_home'): ?>
                    <!-- Admin Panel sau khi đăng nhập thành công -->
                    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <h3 style="color: #1e40af; margin-bottom: 15px;">Khu Vực Quản Trị Viên (Admin Protected Area)</h3>
                        <div style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 6px; padding: 18px; margin-bottom: 20px;">
                            <p style="color: #166534; font-size: 15px; font-weight: bold; margin-bottom: 8px;">
                                ✅ Đăng nhập thành công! Thông tin tài khoản đã được đồng bộ cả trong Session và Cookies.
                            </p>
                            <p style="color: #15803d; font-size: 14px;">
                                <strong>Username trong Session:</strong> <?php echo htmlspecialchars($_SESSION['Username'] ?? ''); ?><br>
                                <strong>Username trong Cookie:</strong> <?php echo htmlspecialchars($_COOKIE['Username'] ?? ''); ?><br>
                                <strong>Trạng thái Cookie:</strong> Còn hiệu lực 30 ngày
                            </p>
                        </div>
                        <a href="index.php?action=logout" style="padding: 7px 18px; background: #dc2626; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
                            Đăng Xuất Khỏi Hệ Thống
                        </a>
                    </div>

                <?php else: ?>
                    <!-- Home -->
                    <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <h3 style="color: #1e40af; margin-bottom: 12px;">Trang Chủ - Nhiệm Vụ 6: Cơ Chế Cookie Trong PHP</h3>
                        <p style="color: #334155; line-height: 1.6; margin-bottom: 15px;">
                            Cookie là đoạn dữ liệu do Web Server gửi xuống và được trình duyệt lưu trữ trên máy Client. Ở các lượt truy vấn tiếp theo, trình duyệt tự động gửi ngược cookie lên server.
                        </p>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
                            <div style="padding: 15px; background: #fefce8; border: 1px solid #fde047; border-radius: 6px;">
                                <h4 style="color: #854d0e; margin-bottom: 6px;">1. Ghi Nhớ Đăng Nhập</h4>
                                <p style="font-size: 13px; color: #713f12; line-height: 1.5;">
                                    Tự động nhớ thông tin tài khoản người dùng đăng nhập trong 30 ngày, tự động điền khi quay lại.
                                </p>
                                <a href="index.php?page=login" style="display: inline-block; margin-top: 10px; color: #2563eb; font-weight: bold; font-size: 13px;">Thử nghiệm Đăng nhập &rarr;</a>
                            </div>
                            <div style="padding: 15px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px;">
                                <h4 style="color: #1e40af; margin-bottom: 6px;">2. Danh Sách Web Ưa Thích</h4>
                                <p style="font-size: 13px; color: #1e3a8a; line-height: 1.5;">
                                    Lưu trữ mảng URL yêu thích ra Cookie dạng JSON, thêm link mới và đọc dữ liệu tức thì.
                                </p>
                                <a href="index.php?page=favorites" style="display: inline-block; margin-top: 10px; color: #2563eb; font-weight: bold; font-size: 13px;">Quản lý Favorite Links &rarr;</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <table class="color-grid">
            <tr>
                <td style="background-color: blue;"></td>
                <td style="background-color: red;"></td>
                <td style="background-color: magenta;"></td>
            </tr>
            <tr>
                <td style="background-color: yellow;"></td>
                <td style="background-color: lime;"></td>
                <td style="background-color: gray;"></td>
            </tr>
            <tr>
                <td style="background-color: skyblue;"></td>
                <td style="background-color: lightgray;"></td>
                <td style="background-color: orangered;"></td>
            </tr>
        </table>
    </footer>
</div>
</body>
</html>
