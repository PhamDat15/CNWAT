<?php
/**
 * Single Entry Point (Front Controller) - Website Bán Laptop MVC & Security
 * Học Viện Kỹ Thuật Mật Mã - Khoa An Toàn Thông Tin
 * Sinh viên: Phạm Tiến Đạt - AT200311
 */

// Báo cáo lỗi thân thiện
error_reporting(E_ALL);
ini_set('display_errors', '0'); // Tắt hiển thị chi tiết lỗi ra màn hình để tránh Information Disclosure

require_once __DIR__ . '/core/Security.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Router.php';

// 1. Khởi động phiên làm việc bảo mật cao (HttpOnly, SameSite, Hijack protection)
Security::startSecureSession();

// 2. Thiết lập OWASP HTTP Security Headers (CSP, X-Frame-Options, X-Content-Type-Options)
Security::setSecurityHeaders();

// 3. Khởi chạy bộ điều hướng Router
try {
    Router::dispatch();
} catch (Throwable $e) {
    error_log("Application Exception: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    http_response_code(500);
    echo '<!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>500 - Lỗi Hệ Thống</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-dark text-white d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card bg-secondary text-white p-4 rounded-4 shadow text-center" style="max-width: 500px;">
            <h2 class="text-danger fw-bold mb-3"><i class="fas fa-exclamation-triangle"></i> Lỗi Hệ Thống (500)</h2>
            <p>Đã xảy ra sự cố trong quá trình xử lý yêu cầu. Vui lòng liên hệ quản trị viên hệ thống để được hỗ trợ!</p>
            <a href="index.php?r=home/index" class="btn btn-primary mt-3">Quay Lại Trang Chủ</a>
        </div>
    </body>
    </html>';
}
