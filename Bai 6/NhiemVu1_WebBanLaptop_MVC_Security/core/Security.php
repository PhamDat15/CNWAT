<?php
/**
 * Security Engine: Các cơ chế an toàn và phòng chống tấn công Web
 * - Phòng chống XSS: HTML output escaping & Content-Security-Policy
 * - Phòng chống SQL Injection: PDO Prepared Statements
 * - Phòng chống CSRF: Dynamic Session Token validation
 * - Bảo vệ Session: HttpOnly, SameSite, Session Hijacking & Fixation check
 * - Phòng chống Brute Force: Rate Limiting với IP & Session
 * - An toàn Tải tệp: Whitelist MIME type & Extension, sanitize tên tệp
 */

class Security {
    /**
     * Khởi tạo Session an toàn với cấu hình cookie chặt chẽ
     */
    public static function startSecureSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            // Ngăn chặn Session Fixation & JavaScript truy cập Cookie qua XSS
            ini_set('session.cookie_httponly', '1');
            ini_set('session.use_only_cookies', '1');
            ini_set('session.cookie_samesite', 'Lax');

            session_start();

            // Chống Session Hijacking: Kiểm tra User-Agent thay đổi đột ngột
            $currentUa = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
            if (!isset($_SESSION['_sec_user_agent'])) {
                $_SESSION['_sec_user_agent'] = md5($currentUa);
            } else {
                if ($_SESSION['_sec_user_agent'] !== md5($currentUa)) {
                    // Phát hiện nghi vấn đánh cắp phiên -> Hủy phiên
                    session_unset();
                    session_destroy();
                    session_start();
                    $_SESSION['_sec_user_agent'] = md5($currentUa);
                }
            }

            // Tự động xoay Session ID sau mỗi 30 phút
            if (!isset($_SESSION['_sec_last_regenerate'])) {
                $_SESSION['_sec_last_regenerate'] = time();
            } elseif (time() - $_SESSION['_sec_last_regenerate'] > 1800) {
                session_regenerate_id(true);
                $_SESSION['_sec_last_regenerate'] = time();
            }
        }
    }

    /**
     * Thiết lập các HTTP Security Headers theo tiêu chuẩn OWASP
     */
    public static function setSecurityHeaders(): void {
        if (!headers_sent()) {
            header("X-Content-Type-Options: nosniff");
            header("X-Frame-Options: SAMEORIGIN");
            header("X-XSS-Protection: 1; mode=block");
            header("Referrer-Policy: strict-origin-when-cross-origin");
            // CSP cho phép tải tài nguyên giao diện từ các CDN uy tín (Bootstrap, FontAwesome, SweetAlert2, Quill)
            header("Content-Security-Policy: default-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://fonts.googleapis.com https://fonts.gstatic.com https://cdnjs.cloudflare.com https://ui-avatars.com data:; img-src 'self' data: https: blob:;");
        }
    }

    /**
     * Sinh mã CSRF Token bảo vệ Form và AJAX request
     */
    public static function generateCsrfToken(): string {
        self::startSecureSession();
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    /**
     * Tạo thẻ input ẩn chứa CSRF Token
     */
    public static function getCsrfField(): string {
        $token = self::generateCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    /**
     * Xác thực CSRF Token từ Form POST hoặc Header
     */
    public static function validateCsrfToken(?string $token = null): bool {
        self::startSecureSession();
        if ($token === null) {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
        }
        if (empty($token) || empty($_SESSION['_csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['_csrf_token'], $token);
    }

    /**
     * Escape output chống XSS (Cross-Site Scripting)
     */
    public static function escape(?string $string): string {
        if ($string === null) {
            return '';
        }
        return htmlspecialchars((string)$string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Làm sạch dữ liệu đầu vào (Sanitization)
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $data[$key] = self::sanitize($val);
            }
            return $data;
        }
        return is_string($data) ? trim(strip_tags($data)) : $data;
    }

    /**
     * Băm mật khẩu một chiều an toàn với thuật toán Bcrypt
     */
    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    /**
     * Kiểm tra mật khẩu Bcrypt
     */
    public static function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }

    /**
     * Chống Brute Force: Giới hạn tần suất thao tác (Rate Limiting)
     */
    public static function checkRateLimit(string $action, int $maxAttempts = 5, int $decaySeconds = 300): bool {
        self::startSecureSession();
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $key = "_ratelimit_{$action}_{$ip}";

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['attempts' => 1, 'first_attempt' => time()];
            return true;
        }

        $record = $_SESSION[$key];
        if (time() - $record['first_attempt'] > $decaySeconds) {
            // Đã hết thời gian chờ -> Reset
            $_SESSION[$key] = ['attempts' => 1, 'first_attempt' => time()];
            return true;
        }

        if ($record['attempts'] >= $maxAttempts) {
            return false; // Bị khóa tạm thời
        }

        $_SESSION[$key]['attempts']++;
        return true;
    }

    /**
     * Xóa bộ đếm Rate Limit khi người dùng đăng nhập thành công
     */
    public static function clearRateLimit(string $action): void {
        self::startSecureSession();
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $key = "_ratelimit_{$action}_{$ip}";
        unset($_SESSION[$key]);
    }

    /**
     * Kiểm tra và kiểm duyệt tệp tin ảnh tải lên an toàn (File Upload Security)
     */
    public static function validateAndUploadImage(array $file, string $targetDir): array {
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['success' => false, 'error' => 'Dữ liệu tệp tin không hợp lệ.'];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Lỗi khi tải tệp lên (Code: ' . $file['error'] . ').'];
        }

        // Giới hạn dung lượng tối đa 5MB
        if ($file['size'] > 5 * 1024 * 1024) {
            return ['success' => false, 'error' => 'Kích thước tệp quá lớn (Tối đa 5MB).'];
        }

        // Kiểm tra phần mở rộng tệp tin
        $fileName = $file['name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($ext, $allowedExts)) {
            return ['success' => false, 'error' => 'Chỉ chấp nhận các định dạng ảnh: JPG, PNG, WEBP, GIF.'];
        }

        // Kiểm tra MIME Type thực tế từ nội dung tệp bằng finfo
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($mime, $allowedMimes)) {
            return ['success' => false, 'error' => 'Nội dung tệp không phải là ảnh hợp lệ!'];
        }

        // Tạo tên tệp ngẫu nhiên chống ghi đè và chống Path Traversal
        $newFileName = 'laptop_' . bin2hex(random_bytes(8)) . '.' . $ext;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $destPath = rtrim($targetDir, '/') . '/' . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            return ['success' => true, 'fileName' => $newFileName];
        }

        return ['success' => false, 'error' => 'Không thể lưu tệp ảnh lên máy chủ.'];
    }

    /**
     * Kiểm tra trạng thái đăng nhập
     */
    public static function isLoggedIn(): bool {
        self::startSecureSession();
        return !empty($_SESSION['user_id']);
    }

    /**
     * Lấy thông tin người dùng hiện tại
     */
    public static function getUser(): ?array {
        self::startSecureSession();
        return $_SESSION['user'] ?? null;
    }

    /**
     * Kiểm tra quyền Admin
     */
    public static function isAdmin(): bool {
        self::startSecureSession();
        return !empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin';
    }
}
