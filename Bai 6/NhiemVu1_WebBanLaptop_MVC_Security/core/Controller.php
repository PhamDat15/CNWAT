<?php
/**
 * Base Controller: Cung cấp các phương thức điều phối MVC, Render View, JSON Response, Flash messages
 */

require_once __DIR__ . '/Security.php';

abstract class Controller {
    /**
     * Render một view bên trong layout
     */
    protected function render(string $view, array $data = [], string $layout = 'main'): void {
        extract($data);
        $contentView = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($contentView)) {
            die("Lỗi: Không tìm thấy view '{$view}' tại đường dẫn: " . Security::escape($contentView));
        }

        if ($layout === 'none') {
            require $contentView;
            return;
        }

        $layoutPath = __DIR__ . '/../views/layouts/' . $layout . '.php';
        if (file_exists($layoutPath)) {
            // Biến $content sẽ được truyền vào layout nếu dùng ob_start() hoặc layout trực tiếp include $contentView
            ob_start();
            require $contentView;
            $content = ob_get_clean();
            require $layoutPath;
        } else {
            require $contentView;
        }
    }

    /**
     * Trả về phản hồi JSON (Dành cho AJAX Requests)
     */
    protected function json($data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Chuyển hướng trang an toàn
     */
    protected function redirect(string $url): void {
        header("Location: {$url}");
        exit;
    }

    /**
     * Kiểm tra phương thức HTTP POST
     */
    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Kiểm tra xem request có phải là AJAX không
     */
    protected function isAjax(): bool {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ||
               (!empty($_SERVER['HTTP_ACCEPT']) && 
                strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);
    }

    /**
     * Lấy tham số GET an toàn
     */
    protected function get(string $key, $default = null) {
        return isset($_GET[$key]) ? Security::sanitize($_GET[$key]) : $default;
    }

    /**
     * Lấy tham số POST an toàn
     */
    protected function post(string $key, $default = null, bool $raw = false) {
        if (!isset($_POST[$key])) {
            return $default;
        }
        return $raw ? $_POST[$key] : Security::sanitize($_POST[$key]);
    }

    /**
     * Thiết lập thông báo Flash (hiển thị 1 lần sau khi redirect)
     */
    protected function setFlash(string $type, string $message): void {
        Security::startSecureSession();
        $_SESSION['_flash'][$type] = $message;
    }

    /**
     * Lấy và xóa thông báo Flash
     */
    public static function getFlash(string $type): ?string {
        Security::startSecureSession();
        if (isset($_SESSION['_flash'][$type])) {
            $msg = $_SESSION['_flash'][$type];
            unset($_SESSION['_flash'][$type]);
            return $msg;
        }
        return null;
    }

    /**
     * Middleware: Bắt buộc đã đăng nhập
     */
    protected function requireAuth(): void {
        if (!Security::isLoggedIn()) {
            $this->setFlash('error', 'Vui lòng đăng nhập để tiếp tục.');
            $this->redirect('index.php?r=auth/login');
        }
    }

    /**
     * Middleware: Bắt buộc quyền Quản trị viên (Admin)
     */
    protected function requireAdmin(): void {
        $this->requireAuth();
        if (!Security::isAdmin()) {
            $this->setFlash('error', 'Truy cập bị từ chối! Bạn không có quyền quản trị viên.');
            $this->redirect('index.php?r=home/index');
        }
    }

    /**
     * Xác thực CSRF Token, nếu không hợp lệ sẽ trả lỗi ngay
     */
    protected function validateCsrfOrAbort(): void {
        if (!Security::validateCsrfToken()) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'error' => 'Mã bảo mật CSRF Token không hợp lệ hoặc đã hết hạn!'], 403);
            } else {
                die('<h2 style="color:red; font-family:sans-serif; text-align:center; margin-top:50px;">LỖI 403: Mã bảo vệ CSRF không hợp lệ hoặc phiên làm việc đã hết hạn. Vui lòng tải lại trang và thử lại!</h2>');
            }
        }
    }
}
