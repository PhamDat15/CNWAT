<?php
/**
 * Admin Layout: Giao diện quản trị viên chuyên nghiệp
 * Tích hợp Rich Text Editor (Quill.js) và Datetime Picker (Flatpickr)
 */

$user = Security::getUser();
$flashSuccess = Controller::getFlash('success');
$flashError = Controller::getFlash('error');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Security::escape($pageTitle ?? 'Admin Control Panel') ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Quill.js Rich Text Editor CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <!-- Flatpickr Datetime Picker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body style="background-color: #f1f5f9;">

    <div class="d-flex">
        <!-- SIDEBAR -->
        <aside class="admin-sidebar d-flex flex-column" style="width: 260px; min-height: 100vh;">
            <div class="px-3 py-3 border-bottom border-secondary mb-3">
                <a href="index.php?r=admin/dashboard" class="d-flex align-items-center gap-2 text-white text-decoration-none">
                    <div class="bg-primary text-white p-2 rounded-3"><i class="fas fa-shield-alt fa-lg"></i></div>
                    <div>
                        <div class="fw-bold fs-6">ADMIN PORTAL</div>
                        <small class="text-secondary" style="font-size: 11px;">Học Viện Mật Mã KMA</small>
                    </div>
                </a>
            </div>

            <nav class="nav flex-column flex-grow-1 px-2">
                <a class="nav-link <?= (($_GET['r'] ?? '') === 'admin/dashboard') ? 'active' : '' ?>" href="index.php?r=admin/dashboard">
                    <i class="fas fa-chart-line fa-fw"></i> Bảng điều khiển
                </a>
                <a class="nav-link <?= (strpos($_GET['r'] ?? '', 'admin/product') !== false) ? 'active' : '' ?>" href="index.php?r=admin/products">
                    <i class="fas fa-laptop fa-fw"></i> Quản lý Laptop
                </a>
                <a class="nav-link <?= (strpos($_GET['r'] ?? '', 'admin/user') !== false) ? 'active' : '' ?>" href="index.php?r=admin/users">
                    <i class="fas fa-users-cog fa-fw"></i> Người dùng &amp; Phân quyền
                </a>
                <a class="nav-link <?= (strpos($_GET['r'] ?? '', 'admin/orders') !== false) ? 'active' : '' ?>" href="index.php?r=admin/orders">
                    <i class="fas fa-receipt fa-fw"></i> Quản lý Đơn hàng
                </a>

                <hr class="border-secondary my-3">
                
                <a class="nav-link text-info" href="index.php?r=home/index">
                    <i class="fas fa-external-link-alt fa-fw"></i> Xem Cửa hàng (Client)
                </a>
            </nav>

            <div class="p-3 border-top border-secondary">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <img src="https://ui-avatars.com/api/?name=Admin+KMA&background=ef4444&color=fff&size=32" class="rounded-circle" width="32" height="32" alt="Admin">
                    <div class="overflow-hidden">
                        <div class="text-white small fw-bold text-truncate"><?= Security::escape($user['fullname']) ?></div>
                        <span class="badge bg-danger" style="font-size: 10px;">ROOT ADMIN</span>
                    </div>
                </div>
                <a href="index.php?r=auth/logout" class="btn btn-sm btn-outline-danger w-100 mt-2">
                    <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                </a>
            </div>
        </aside>

        <!-- MAIN ADMIN CONTENT -->
        <div class="flex-grow-1 d-flex flex-column" style="min-width: 0;">
            <!-- TOP BAR -->
            <header class="bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><?= Security::escape($pageTitle ?? 'Quản Trị Hệ Thống') ?></h5>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                        <i class="fas fa-shield-check me-1"></i> RBAC Security Active
                    </span>
                    <a href="index.php?r=home/index" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-store me-1"></i> Xem Website
                    </a>
                </div>
            </header>

            <!-- FLASH ALERTS -->
            <div class="px-4 mt-3">
                <?php if ($flashSuccess): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i> <?= Security::escape($flashSuccess) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if ($flashError): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> <?= Security::escape($flashError) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- VIEW CONTENT BODY -->
            <div class="p-4 flex-grow-1">
                <?= $content ?>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Quill.js Rich Text Editor -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <!-- Flatpickr Datetime Picker -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>
    <!-- Custom Application JS -->
    <script src="assets/js/app.js"></script>
</body>
</html>
