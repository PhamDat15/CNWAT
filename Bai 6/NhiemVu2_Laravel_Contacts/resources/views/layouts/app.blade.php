<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản Lý Danh Bạ - Laravel Contacts')</title>
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
            @yield('content')
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
