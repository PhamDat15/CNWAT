<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Danh Bạ - Contacts Management</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Flatpickr Datetime Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-light: #f8fafc;
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-light);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-brand-badge {
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            color: white;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .contact-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.25s ease;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .contact-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.12);
            border-color: #c7d2fe;
        }
        .contact-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e0e7ff;
        }
        .badge-cat-Gia-dinh { background-color: #fee2e2; color: #b91c1c; }
        .badge-cat-Ban-be { background-color: #e0e7ff; color: #4338ca; }
        .badge-cat-Cong-viec { background-color: #e0f2fe; color: #0369a1; }
        .badge-cat-Khach-hang { background-color: #fef3c7; color: #b45309; }
        .badge-cat-Doi-tac { background-color: #dcfce7; color: #15803d; }
        .badge-cat-Khac { background-color: #f1f5f9; color: #475569; }
    </style>
</head>
<body>

    <!-- TOP SECURITY BAR -->
    <div class="bg-dark text-white py-1 px-3 small border-bottom border-secondary">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-danger me-2"><i class="fab fa-laravel"></i> Laravel Framework 11</span>
                <span class="text-secondary d-none d-md-inline">Ứng dụng Quản lý Danh bạ (Contacts App) &bull; Nhiệm vụ 6.2</span>
            </div>
            <div>
                <span class="text-info fw-bold"><i class="fas fa-user-graduate"></i> Phạm Tiến Đạt - AT200311</span>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand-badge" href="index.php">
                <i class="fas fa-address-book fa-lg"></i>
                <span>CONTACTS<span style="color: #67e8f9;">HUB</span></span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContacts">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContacts">
                <ul class="navbar-nav me-auto ms-lg-4 mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3" href="index.php"><i class="fas fa-list me-1"></i> Tất cả liên hệ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3" href="index.php?r=contacts/create"><i class="fas fa-user-plus me-1"></i> Thêm liên hệ mới</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3 text-success" href="index.php?r=contacts/export"><i class="fas fa-file-csv me-1"></i> Xuất CSV</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="../NhiemVu1_WebBanLaptop_MVC_Security/index.php" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="fas fa-laptop me-1"></i> Sang Website Laptop MVC (NV 6.1)
                    </a>
                    <a href="index.php?r=contacts/create" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm" style="background-color: var(--primary-color);">
                        <i class="fas fa-plus me-1"></i> Thêm Mới
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTAINER -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            
<div class="mb-4">
    <!-- FLASH ALERTS -->
    <?php if (!empty($_SESSION['_flash']['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($_SESSION['_flash']['success'] ?? "", ENT_QUOTES, "UTF-8") ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- STATS CHIPS & SEARCH BAR -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
        <div class="row g-3 align-items-center justify-content-between mb-3">
            <div class="col-md-5">
                <h4 class="fw-bold mb-1"><i class="fas fa-address-book text-primary me-2"></i>Danh Bạ Liên Hệ</h4>
                <p class="text-secondary small mb-0">Tổng cộng có <strong><?= htmlspecialchars((string)($totalContacts ?? count($contacts)), ENT_QUOTES, "UTF-8") ?></strong> liên hệ được lưu trữ an toàn</p>
            </div>
            <div class="col-md-7">
                <form action="index.php" method="GET" class="d-flex gap-2">
                    <input type="hidden" name="r" value="contacts/index">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Tìm theo tên, số điện thoại hoặc email..." value="<?= htmlspecialchars((string)($search ?? ''), ENT_QUOTES, "UTF-8") ?>">
                    </div>
                    <?php if (!empty($category)): ?>
                        <input type="hidden" name="category" value="<?= htmlspecialchars((string)($category), ENT_QUOTES, "UTF-8") ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary px-3" style="background-color: var(--primary-color);">Tìm</button>
                    <?php if (!empty($search) || !empty($category)): ?>
                        <a href="index.php" class="btn btn-outline-secondary">Xóa lọc</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- CATEGORY PILLS -->
        <div class="d-flex flex-wrap gap-2 pt-2 border-top">
            <span class="small text-muted align-self-center me-2">Phân loại:</span>
            <a href="index.php?r=contacts/index&search=<?= htmlspecialchars((string)(urlencode($search ?? '')), ENT_QUOTES, "UTF-8") ?>" class="btn btn-sm rounded-pill <?= htmlspecialchars((string)(empty($category) ? 'btn-primary' : 'btn-light border'), ENT_QUOTES, "UTF-8") ?>">
                Tất cả
            </a>
            <?php foreach (['Gia đình', 'Bạn bè', 'Công việc', 'Khách hàng', 'Đối tác', 'Khác'] as $cat): ?>
                <a href="index.php?r=contacts/index&category=<?= htmlspecialchars((string)(urlencode($cat)), ENT_QUOTES, "UTF-8") ?>&search=<?= htmlspecialchars((string)(urlencode($search ?? '')), ENT_QUOTES, "UTF-8") ?>" class="btn btn-sm rounded-pill <?= htmlspecialchars((string)(($category ?? '') === $cat ? 'btn-primary' : 'btn-light border'), ENT_QUOTES, "UTF-8") ?>">
                    <?= htmlspecialchars((string)($cat), ENT_QUOTES, "UTF-8") ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- CONTACT CARDS GRID -->
    <?php if (empty($contacts)): ?>
        <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center">
            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
            <h5>Chưa tìm thấy liên hệ nào phù hợp!</h5>
            <p class="text-secondary small">Bạn có thể tạo mới liên hệ hoặc thử tìm kiếm với từ khóa khác.</p>
            <div class="mt-2">
                <a href="index.php?r=contacts/create" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-plus me-1"></i> Thêm Liên Hệ Mới
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($contacts as $c): ?>
                <?php 
                    $safeCatClass = 'badge-cat-' . str_replace(' ', '-', $c['category']);
                 ?>
                <div class="col-md-6 col-lg-4">
                    <div class="contact-card p-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <?php if (!empty($c['avatar'])): ?>
                                <img src="public/uploads/<?= htmlspecialchars((string)($c['avatar']), ENT_QUOTES, "UTF-8") ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?= htmlspecialchars((string)(urlencode($c['name'])), ENT_QUOTES, "UTF-8") ?>&background=4f46e5&color=fff&size=64'" class="contact-avatar" alt="<?= htmlspecialchars((string)($c['name']), ENT_QUOTES, "UTF-8") ?>">
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?= htmlspecialchars((string)(urlencode($c['name'])), ENT_QUOTES, "UTF-8") ?>&background=4f46e5&color=fff&size=64" class="contact-avatar" alt="<?= htmlspecialchars((string)($c['name']), ENT_QUOTES, "UTF-8") ?>">
                            <?php endif; ?>
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="fw-bold text-dark mb-1 text-truncate" title="<?= htmlspecialchars((string)($c['name']), ENT_QUOTES, "UTF-8") ?>">
                                    <a href="index.php?r=contacts/show&id=<?= htmlspecialchars((string)($c['id']), ENT_QUOTES, "UTF-8") ?>" class="text-dark text-decoration-none">
                                        <?= htmlspecialchars((string)($c['name']), ENT_QUOTES, "UTF-8") ?>
                                    </a>
                                </h5>
                                <span class="badge <?= htmlspecialchars((string)($safeCatClass), ENT_QUOTES, "UTF-8") ?> rounded-pill px-3 py-1 font-monospace small">
                                    <?= htmlspecialchars((string)($c['category']), ENT_QUOTES, "UTF-8") ?>
                                </span>
                            </div>
                        </div>

                        <div class="small text-secondary mb-3 flex-grow-1">
                            <div class="mb-1 text-truncate">
                                <i class="fas fa-phone-alt text-primary fa-fw me-2"></i>
                                <a href="tel:<?= htmlspecialchars((string)($c['phone']), ENT_QUOTES, "UTF-8") ?>" class="text-dark text-decoration-none fw-semibold"><?= htmlspecialchars((string)($c['phone']), ENT_QUOTES, "UTF-8") ?></a>
                            </div>
                            <?php if (!empty($c['email'])): ?>
                                <div class="mb-1 text-truncate">
                                    <i class="fas fa-envelope text-info fa-fw me-2"></i>
                                    <a href="mailto:<?= htmlspecialchars((string)($c['email']), ENT_QUOTES, "UTF-8") ?>" class="text-secondary text-decoration-none"><?= htmlspecialchars((string)($c['email']), ENT_QUOTES, "UTF-8") ?></a>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($c['birthdate'])): ?>
                                <div class="mb-1 text-truncate">
                                    <i class="fas fa-birthday-cake text-warning fa-fw me-2"></i>
                                    <span><?= htmlspecialchars((string)(date('d/m/Y', strtotime($c['birthdate']))), ENT_QUOTES, "UTF-8") ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($c['address'])): ?>
                                <div class="text-truncate" title="<?= htmlspecialchars((string)($c['address']), ENT_QUOTES, "UTF-8") ?>">
                                    <i class="fas fa-map-marker-alt text-danger fa-fw me-2"></i>
                                    <span><?= htmlspecialchars((string)($c['address']), ENT_QUOTES, "UTF-8") ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- ACTIONS -->
                        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <a href="tel:<?= htmlspecialchars((string)($c['phone']), ENT_QUOTES, "UTF-8") ?>" class="btn btn-sm btn-outline-success rounded-circle" title="Gọi điện">
                                    <i class="fas fa-phone"></i>
                                </a>
                                <?php if (!empty($c['email'])): ?>
                                    <a href="mailto:<?= htmlspecialchars((string)($c['email']), ENT_QUOTES, "UTF-8") ?>" class="btn btn-sm btn-outline-info rounded-circle" title="Gửi email">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="index.php?r=contacts/show&id=<?= htmlspecialchars((string)($c['id']), ENT_QUOTES, "UTF-8") ?>" class="btn btn-sm btn-outline-secondary" title="Chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?r=contacts/edit&id=<?= htmlspecialchars((string)($c['id']), ENT_QUOTES, "UTF-8") ?>" class="btn btn-sm btn-outline-primary" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="index.php?r=contacts/destroy" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="f001bf61e4a2ac32cec61904b96dc2b6d024c2c46aedc911b08402c09f8cc776">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars((string)($c['id']), ENT_QUOTES, "UTF-8") ?>">
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-contact" title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container text-center small text-secondary">
            <div class="mb-2">
                <strong>Học Viện Kỹ Thuật Mật Mã - Khoa An Toàn Thông Tin</strong> &bull; Học phần: Công Nghệ Web An Toàn
            </div>
            <div>
                Sinh viên thực hiện: <strong>Phạm Tiến Đạt</strong> - MSSV: <strong>AT200311</strong> - Lớp: <strong>AT20A</strong>
            </div>
        </div>
    </footer>

    <!-- JS SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>
    <script>
        $(document).on('click', '.btn-delete-contact', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Xác nhận xóa liên hệ?',
                text: 'Dữ liệu liên hệ này sẽ bị xóa khỏi danh bạ.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Đồng ý xóa',
                cancelButtonText: 'Hủy bỏ'
            }).then((res) => {
                if (res.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
