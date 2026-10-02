<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 10: ĐA NGÔN NGỮ
// ========================================================
session_start();

// 1. Lấy thông tin page hiện tại
$page = $_GET['page'] ?? 'home';
if (isset($_POST['page'])) {
    $page = $_POST['page'];
}

// 2. Xử lý chuyển đổi ngôn ngữ bằng session
if (isset($_POST['btnEnglish'])) {
    $_SESSION['lang'] = 'english';
    header("Location: index.php?page=" . urlencode($page));
    exit();
}
if (isset($_POST['btnVietnamese'])) {
    $_SESSION['lang'] = 'vietnamese';
    header("Location: index.php?page=" . urlencode($page));
    exit();
}

// 3. Thiết lập ngôn ngữ mặc định nếu chưa có
$lang = $_SESSION['lang'] ?? 'vietnamese';

// 4. Nhúng tệp từ điển ngôn ngữ tương ứng
require_once __DIR__ . "/lang/" . $lang . ".php";
?>
<!DOCTYPE html>
<html lang="<?php echo ($lang == 'english') ? 'en' : 'vi'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo HOME; ?> - Multi-Language Web | Phạm Tiến Đạt - AT200311</title>
    <link rel="stylesheet" href="../NhiemVu03_LayVaGuiDuLieu/style.css">
    <style>
        .lang-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #1e293b;
            padding: 8px 15px;
            border-bottom: 1px solid #334155;
        }
        .lang-switchers {
            display: flex;
            gap: 8px;
        }
        .lang-btn {
            background: #334155;
            color: white;
            border: 1px solid #475569;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }
        .lang-btn.active {
            background: #2563eb;
            border-color: #3b82f6;
        }
        .lang-nav {
            display: flex;
            gap: 15px;
        }
        .lang-nav a {
            color: #f1f5f9;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .lang-nav a.active {
            color: #60a5fa;
            border-bottom: 2px solid #60a5fa;
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
                <li><a href="../NhiemVu06_Cookie/index.php">3.6. Cookie (NV6)</a></li>
                <li><a href="../NhiemVu07_Function/index.php">3.7. Thư viện Function (NV7)</a></li>
                <li><a href="../NhiemVu08_DocGhiFile/index.php">3.8. Đọc ghi file (NV8)</a></li>
                <li><a href="../NhiemVu09_QuanLyFile_QLSV/index.php">3.9. Quản lý file QLSV (NV9)</a></li>
                <li><a href="index.php"><strong>3.10. Website đa ngôn ngữ (NV10)</strong></a></li>
                <li><a href="../NhiemVu11_CSDL_QuanLyHocSinh/lop_list.php">3.11. CSDL QLHS (NV11)</a></li>
                <li><a href="../NhiemVu12_TruyVanDuLieu/ListClass.php">3.12. Truy vấn dữ liệu (NV12)</a></li>
                <li><a href="../NhiemVu13_16_WebBanLaptop/index.php">3.13-16. Web bán laptop</a></li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Thanh chọn ngôn ngữ và điều hướng menu -->
            <div class="lang-bar">
                <form method="POST" action="index.php" style="display: flex; gap: 6px; margin: 0;">
                    <input type="hidden" name="page" value="<?php echo htmlspecialchars($page); ?>">
                    <button type="submit" name="btnVietnamese" class="lang-btn <?php echo ($lang == 'vietnamese') ? 'active' : ''; ?>">
                        🇻🇳 <?php echo VIETNAMESE; ?>
                    </button>
                    <button type="submit" name="btnEnglish" class="lang-btn <?php echo ($lang == 'english') ? 'active' : ''; ?>">
                        🇬🇧 <?php echo ENGLISH; ?>
                    </button>
                </form>

                <div class="lang-nav">
                    <a href="index.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>"><?php echo HOME; ?></a>
                    <a href="index.php?page=contact" class="<?php echo ($page == 'contact') ? 'active' : ''; ?>"><?php echo CONTACT; ?></a>
                    <a href="index.php?page=introduction" class="<?php echo ($page == 'introduction') ? 'active' : ''; ?>"><?php echo INTRODUCTION; ?></a>
                    <a href="index.php?page=login" class="<?php echo ($page == 'login') ? 'active' : ''; ?>"><?php echo LOGIN; ?></a>
                </div>
            </div>

            <!-- Content Body -->
            <div class="content">
                <?php if ($page == 'contact'): ?>
                    <!-- Form Liên Hệ Đa Ngôn Ngữ -->
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; max-width: 540px; margin: 0 auto;">
                        <h3 style="text-align: center; color: #1e40af; margin-bottom: 20px;"><?php echo CONTACT_TITLE; ?></h3>
                        
                        <?php if (isset($_POST['btnContactSubmit'])): ?>
                            <div style="padding: 12px; background: #dcfce7; color: #15803d; border-radius: 4px; margin-bottom: 15px; font-weight: bold; text-align: center;">
                                <?php echo SUCCESS_CONTACT; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?page=contact">
                            <table border="0" cellpadding="8" style="width: 100%;">
                                <tr>
                                    <td style="width: 130px; font-weight: bold;"><?php echo USERNAME; ?>:</td>
                                    <td><input type="text" name="txtUser" style="width: 100%; padding: 6px;" required></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;"><?php echo BIRTHDAY; ?>:</td>
                                    <td><input type="date" name="txtBirth" value="2002-05-19" style="width: 100%; padding: 6px;" required></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;"><?php echo ADDRESS; ?>:</td>
                                    <td><input type="text" name="txtAddress" style="width: 100%; padding: 6px;" required></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;"><?php echo EMAIL; ?>:</td>
                                    <td><input type="email" name="txtEmail" style="width: 100%; padding: 6px;" required></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;"><?php echo PHONE; ?>:</td>
                                    <td><input type="tel" name="txtPhone" style="width: 100%; padding: 6px;"></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; vertical-align: top;"><?php echo COMMENT; ?>:</td>
                                    <td><textarea name="txtComment" rows="3" style="width: 100%; padding: 6px;"></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right; padding-top: 15px;">
                                        <input type="reset" value="<?php echo RESET; ?>" style="padding: 6px 16px; margin-right: 8px;">
                                        <input type="submit" name="btnContactSubmit" value="<?php echo SUBMIT; ?>" style="padding: 6px 22px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>

                <?php elseif ($page == 'introduction'): ?>
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px;">
                        <h3 style="color: #1e40af; margin-bottom: 12px;"><?php echo INTRO_TITLE; ?></h3>
                        <p style="color: #334155; line-height: 1.8; font-size: 15px;"><?php echo INTRO_CONTENT; ?></p>
                    </div>

                <?php elseif ($page == 'login'): ?>
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; max-width: 420px; margin: 20px auto;">
                        <h3 style="color: #1e40af; text-align: center; margin-bottom: 18px;"><?php echo LOGIN; ?></h3>
                        <form method="POST" action="index.php?page=login">
                            <div style="margin-bottom: 12px;">
                                <label style="display: block; font-weight: bold; margin-bottom: 5px;"><?php echo USERNAME; ?>:</label>
                                <input type="text" name="u" style="width: 100%; padding: 6px;" required>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Password:</label>
                                <input type="password" name="p" style="width: 100%; padding: 6px;" required>
                            </div>
                            <div style="text-align: center;">
                                <input type="submit" value="<?php echo LOGIN; ?>" style="padding: 7px 25px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                            </div>
                        </form>
                    </div>

                <?php else: ?>
                    <!-- Home -->
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 30px; text-align: center;">
                        <h2 style="color: #1e40af; margin-bottom: 15px; font-size: 24px;"><?php echo WELCOME; ?></h2>
                        <p style="color: #475569; font-size: 16px; line-height: 1.8; max-width: 600px; margin: 0 auto;"><?php echo HOME_DESC; ?></p>
                        
                        <div style="margin-top: 25px; display: inline-flex; gap: 15px;">
                            <a href="index.php?page=contact" style="padding: 8px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">
                                <?php echo CONTACT; ?> &rarr;
                            </a>
                            <a href="index.php?page=introduction" style="padding: 8px 20px; background: #f1f5f9; color: #1e293b; text-decoration: none; border-radius: 6px; font-weight: bold; border: 1px solid #cbd5e1;">
                                <?php echo INTRODUCTION; ?>
                            </a>
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
