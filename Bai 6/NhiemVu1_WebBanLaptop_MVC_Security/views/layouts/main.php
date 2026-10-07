<?php
/**
 * Main Layout: Client Header, Navigation, Flash Messages, Content, Footer
 */

$user = Security::getUser();
$cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
$flashSuccess = Controller::getFlash('success');
$flashError = Controller::getFlash('error');
$flashWarning = Controller::getFlash('warning');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Security::escape($pageTitle ?? 'LaptopStore - Công Nghệ Web An Toàn') ?></title>
    <!-- Favicon -->
    <link rel="icon" href="assets/images/avatar.jpg" type="image/jpeg">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>

    <!-- TOP SECURITY NOTIFICATION BAR -->
    <div class="bg-dark text-white py-1 px-3 small border-bottom border-secondary">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-success me-2"><i class="fas fa-shield-alt"></i> OWASP Protected</span>
                <span class="text-secondary d-none d-md-inline">Bảo vệ SQL Injection (PDO), XSS (Escaped), CSRF Tokens, Bcrypt Password &amp; Session Fixation Guard</span>
            </div>
            <div>
                <span class="text-info fw-bold"><i class="fas fa-user-graduate"></i> Phạm Tiến Đạt - AT200311</span>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container">
            <a class="brand-badge text-white" href="index.php?r=home/index">
                <i class="fas fa-laptop-code fa-lg"></i>
                <span>LAPTOP<span style="color: #67e8f9;">PRO</span></span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Search Box với AJAX Live Search -->
                <div class="mx-lg-auto my-3 my-lg-0 search-wrapper">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" id="headerSearchInput" class="form-control border-start-0 ps-0" placeholder="Tìm kiếm laptop theo tên, hãng..." autocomplete="off">
                    </div>
                    <div id="searchDropdown" class="search-results-dropdown"></div>
                </div>

                <!-- Navigation Links -->
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3" href="index.php?r=home/index"><i class="fas fa-home me-1"></i> Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3" href="index.php?r=product/index"><i class="fas fa-laptop me-1"></i> Sản phẩm</a>
                    </li>

                    <!-- Dropdown Hãng Laptop -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold px-3" href="#" role="button" data-bs-toggle="dropdown">
                            Thương hiệu
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0">
                            <li><a class="dropdown-item" href="index.php?r=product/index&brand=Dell"><i class="fab fa-windows me-2 text-primary"></i>Dell</a></li>
                            <li><a class="dropdown-item" href="index.php?r=product/index&brand=Asus"><i class="fas fa-microchip me-2 text-danger"></i>Asus</a></li>
                            <li><a class="dropdown-item" href="index.php?r=product/index&brand=Apple"><i class="fab fa-apple me-2 text-dark"></i>Apple (MacBook)</a></li>
                            <li><a class="dropdown-item" href="index.php?r=product/index&brand=HP"><i class="fas fa-desktop me-2 text-info"></i>HP</a></li>
                            <li><a class="dropdown-item" href="index.php?r=product/index&brand=Lenovo"><i class="fas fa-keyboard me-2 text-warning"></i>Lenovo</a></li>
                            <li><a class="dropdown-item" href="index.php?r=product/index&brand=Acer"><i class="fas fa-gamepad me-2 text-success"></i>Acer</a></li>
                        </ul>
                    </li>

                    <!-- Giỏ hàng Icon với Badge Real-time -->
                    <li class="nav-item">
                        <a class="btn btn-outline-primary position-relative rounded-pill px-3 py-2 ms-lg-2" href="index.php?r=cart/index">
                            <i class="fas fa-shopping-cart me-1"></i>
                            <span class="d-none d-sm-inline">Giỏ hàng</span>
                            <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger <?= $cartCount > 0 ? '' : 'd-none' ?>">
                                <?= $cartCount ?>
                            </span>
                        </a>
                    </li>

                    <!-- User Account / Role Menu -->
                    <?php if ($user): ?>
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['fullname']) ?>&background=2563eb&color=fff&size=32" class="rounded-circle" width="32" height="32" alt="Avatar">
                                <span><?= Security::escape($user['fullname']) ?></span>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="badge bg-danger ms-1">ADMIN</span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <?php if ($user['role'] === 'admin'): ?>
                                    <li><a class="dropdown-item text-primary fw-bold" href="index.php?r=admin/dashboard"><i class="fas fa-user-shield me-2"></i>Trang Quản Trị Admin</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="index.php?r=auth/profile"><i class="fas fa-user-circle me-2"></i>Hồ sơ cá nhân</a></li>
                                <li><a class="dropdown-item text-danger" href="index.php?r=auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-primary rounded-pill px-4 py-2" href="index.php?r=auth/login">
                                <i class="fas fa-sign-in-alt me-1"></i> Đăng nhập
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGES -->
    <div class="container mt-3">
        <?php if ($flashSuccess): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?= Security::escape($flashSuccess) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($flashError): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> <?= Security::escape($flashError) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($flashWarning): ?>
            <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="fas fa-info-circle me-2"></i> <?= Security::escape($flashWarning) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- MAIN VIEW CONTENT -->
    <main class="flex-grow-1">
        <?= $content ?>
    </main>

    <!-- FOOTER -->
    <footer class="bg-dark text-white pt-5 pb-4 mt-5 border-top border-secondary">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="brand-badge text-white mb-3">
                        <i class="fas fa-laptop-code"></i> LAPTOPPRO SECURITY
                    </div>
                    <p class="text-secondary small">
                        Hệ thống bán lẻ thiết bị công nghệ &amp; laptop cao cấp được thiết kế theo mô hình kiến trúc MVC, bảo vệ tối đa trước các cuộc tấn công SQL Injection, XSS, CSRF và Brute Force.
                    </p>
                    <div class="d-flex gap-3 text-secondary">
                        <span class="badge bg-secondary"><i class="fas fa-lock"></i> SSL / TLS</span>
                        <span class="badge bg-secondary"><i class="fas fa-shield-virus"></i> CSRF Token</span>
                        <span class="badge bg-secondary"><i class="fas fa-database"></i> PDO Prepared</span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h6 class="text-uppercase fw-bold text-light mb-3">Thương Hiệu</h6>
                    <ul class="list-unstyled small text-secondary">
                        <li class="mb-2"><a href="index.php?r=product/index&brand=Dell" class="text-secondary text-decoration-none">Dell XPS / Vostro</a></li>
                        <li class="mb-2"><a href="index.php?r=product/index&brand=Asus" class="text-secondary text-decoration-none">Asus ROG / ZenBook</a></li>
                        <li class="mb-2"><a href="index.php?r=product/index&brand=Apple" class="text-secondary text-decoration-none">Apple MacBook Pro/Air</a></li>
                        <li class="mb-2"><a href="index.php?r=product/index&brand=Lenovo" class="text-secondary text-decoration-none">Lenovo ThinkPad</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-uppercase fw-bold text-light mb-3">Cơ Chế An Toàn (OWASP)</h6>
                    <ul class="list-unstyled small text-secondary">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Chống SQLi qua Prepared Statements</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Bảo vệ CSRF cho mọi Form POST</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Mã hóa mật khẩu Bcrypt</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Rate Limit chống Brute Force</li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="text-uppercase fw-bold text-light mb-3">Tác Giả Thực Hiện</h6>
                    <p class="small text-secondary mb-1"><strong>Sinh viên:</strong> Phạm Tiến Đạt</p>
                    <p class="small text-secondary mb-1"><strong>MSSV:</strong> AT200311 &bull; <strong>Lớp:</strong> AT20A</p>
                    <p class="small text-secondary mb-1"><strong>Học phần:</strong> Công Nghệ Web An Toàn (CNWAT)</p>
                    <p class="small text-secondary"><strong>Đơn vị:</strong> Học viện Kỹ thuật Mật mã (KMA)</p>
                </div>
            </div>

            <hr class="border-secondary my-4">
            <div class="text-center text-secondary small">
                &copy; <?= date('Y') ?> LaptopPro MVC Security &bull; Báo Cáo Thực Hành Lab 6 &bull; Bản quyền thuộc về Phạm Tiến Đạt AT200311
            </div>
        </div>
    </footer>

    <!-- jQuery & Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom Application JS -->
    <script src="assets/js/app.js"></script>
</body>
</html>
