<?php
/**
 * Routing Engine: Điều hướng URL linh hoạt
 * Hỗ trợ URL Rewriting dạng /products, /cart, /admin/products
 * và fallback query string: index.php?r=product/index hoặc ?c=product&a=index
 */

class Router {
    public static function dispatch(): void {
        // Lấy route từ các nguồn: $_GET['r'], $_GET['url'], $_GET['c'], hoặc PATH_INFO
        $route = $_GET['r'] ?? $_GET['url'] ?? '';

        if (empty($route) && isset($_GET['c'])) {
            $controller = $_GET['c'];
            $action = $_GET['a'] ?? 'index';
            $route = $controller . '/' . $action;
        }

        if (empty($route)) {
            // Lấy từ PATH_INFO nếu có mod_rewrite
            $pathInfo = $_SERVER['PATH_INFO'] ?? '';
            $route = trim($pathInfo, '/');
        }

        if (empty($route)) {
            $route = 'home/index';
        }

        $parts = explode('/', trim($route, '/'));

        // Kiểm tra phân hệ admin
        if ($parts[0] === 'admin') {
            $controllerName = 'AdminController';
            $actionName = $parts[1] ?? 'dashboard';
        } else {
            $controllerName = ucfirst($parts[0]) . 'Controller';
            $actionName = $parts[1] ?? 'index';
        }

        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            self::render404("Không tìm thấy Controller '{$controllerName}'");
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            self::render404("Lớp '{$controllerName}' không tồn tại");
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $actionName)) {
            self::render404("Hành động '{$actionName}' không tồn tại trong '{$controllerName}'");
            return;
        }

        // Gọi method
        $controller->$actionName();
    }

    private static function render404(string $msg): void {
        http_response_code(404);
        echo '<!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <title>404 - Không tìm thấy trang</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { background: #0f172a; color: #f8fafc; font-family: system-ui, -apple-system, sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
                .card-404 { background: #1e293b; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 40px; text-align: center; max-width: 500px; box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
                .code { font-size: 80px; font-weight: 800; color: #38bdf8; line-height: 1; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <div class="card-404">
                <div class="code">404</div>
                <h3 class="mb-3">Không tìm thấy trang yêu cầu</h3>
                <p class="text-secondary mb-4">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</p>
                <a href="index.php?r=home/index" class="btn btn-primary px-4 py-2">Quay lại Trang Chủ</a>
            </div>
        </body>
        </html>';
        exit;
    }
}
