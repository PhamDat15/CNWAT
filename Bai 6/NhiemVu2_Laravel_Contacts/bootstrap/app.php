<?php
/**
 * Laravel Standalone Kernel & Blade Engine
 * Cung cấp môi trường chạy độc lập tương thích hoàn toàn cấu trúc Laravel Framework
 * Hỗ trợ Blade View Compiler, Routing, Database Driver PDO (MySQL & SQLite Auto-fallback), Form Validation, CSRF
 */

class LaravelKernel {
    private static ?PDO $db = null;

    public static function init(): void {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', '1');
            ini_set('session.cookie_samesite', 'Lax');
            session_start();
        }
        self::initDatabase();
    }

    public static function getDb(): PDO {
        if (self::$db === null) {
            self::initDatabase();
        }
        return self::$db;
    }

    private static function initDatabase(): void {
        $host = '127.0.0.1';
        $dbName = 'contacts_laravel';
        $user = 'root';
        $pass = '';

        try {
            // Thử kết nối MySQL
            $initPdo = new PDO("mysql:host={$host};charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 2
            ]);
            $initPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

            self::$db = new PDO("mysql:host={$host};dbname={$dbName};charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            self::createSchemaAndSeed(self::$db, 'mysql');
        } catch (PDOException $e) {
            // Fallback sang SQLite
            $dbDir = __DIR__ . '/../database';
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0777, true);
            }
            $sqliteFile = $dbDir . '/database.sqlite';
            self::$db = new PDO("sqlite:" . $sqliteFile, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            self::createSchemaAndSeed(self::$db, 'sqlite');
        }
    }

    private static function createSchemaAndSeed(PDO $pdo, string $driver): void {
        try {
            $check = ($driver === 'mysql') 
                ? "SHOW TABLES LIKE 'contacts'" 
                : "SELECT name FROM sqlite_master WHERE type='table' AND name='contacts'";
            $res = $pdo->query($check)->fetch();
            if ($res) {
                return;
            }

            if ($driver === 'mysql') {
                $pdo->exec("
                    CREATE TABLE IF NOT EXISTS `contacts` (
                        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        `name` VARCHAR(150) NOT NULL,
                        `phone` VARCHAR(20) NOT NULL,
                        `email` VARCHAR(100) NULL,
                        `address` VARCHAR(255) NULL,
                        `category` VARCHAR(50) NOT NULL DEFAULT 'Bạn bè',
                        `birthdate` DATE NULL,
                        `notes` TEXT NULL,
                        `avatar` VARCHAR(255) NULL,
                        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                ");
            } else {
                $pdo->exec("
                    CREATE TABLE IF NOT EXISTS contacts (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        name TEXT NOT NULL,
                        phone TEXT NOT NULL,
                        email TEXT,
                        address TEXT,
                        category TEXT NOT NULL DEFAULT 'Bạn bè',
                        birthdate TEXT,
                        notes TEXT,
                        avatar TEXT,
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
                    );
                ");
            }

            // Seed dữ liệu mẫu ban đầu
            $seedData = [
                ['TS. Nguyễn Văn Hùng', '0912345678', 'hungnv@kma.edu.vn', 'Khoa An Toàn Thông Tin, KMA', 'Công việc', '1982-05-15', 'Giảng viên hướng dẫn môn học Công nghệ Web An Toàn.'],
                ['Phạm Tiến Đạt', '0988776655', 'datpt@kma.edu.vn', 'Hà Nội, Việt Nam', 'Gia đình', '2004-10-20', 'Sinh viên AT200311 - Lớp AT20A.'],
                ['Trần Hoàng Minh', '0978123456', 'minhth@gmail.com', '141 Chiến Thắng, Tân Triều, Thanh Trì, Hà Nội', 'Bạn bè', '2004-03-12', 'Bạn cùng lớp AT20A, nhóm trưởng bài tập lớn.'],
                ['Lê Thị Mai Anh', '0936998877', 'maianh.le@fpt.com.vn', 'Cầu Giấy, Hà Nội', 'Đối tác', '2001-08-25', 'Quản lý tuyển dụng nhân sự FPT Software.'],
                ['Vũ Quốc Bảo', '0904556677', 'baovq@techcombank.com.vn', 'Hoàn Kiếm, Hà Nội', 'Khách hàng', '1995-12-05', 'Khách hàng tư vấn giải pháp kiểm thử xâm nhập web.'],
                ['Nguyễn Hải Yến', '0982334455', 'haiyen.nguyen@gmail.com', 'Hà Đông, Hà Nội', 'Bạn bè', '2004-11-30', 'Thành viên CLB KMA Security Club.']
            ];

            $stmt = $pdo->prepare("INSERT INTO contacts (name, phone, email, address, category, birthdate, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
            foreach ($seedData as $item) {
                $stmt->execute($item);
            }
        } catch (Exception $ex) {
            error_log("Seed contacts error: " . $ex->getMessage());
        }
    }

    /**
     * Blade Compiler đơn giản, tốc độ cao
     */
    public static function renderBlade(string $viewPath, array $data = []): void {
        extract($data);

        // Hàm helper cho view
        $csrf_token = self::csrfToken();
        $session = function($key) {
            return $_SESSION['_flash'][$key] ?? null;
        };

        $fullPath = __DIR__ . '/../resources/views/' . str_replace('.', '/', $viewPath) . '.blade.php';
        if (!file_exists($fullPath)) {
            die("Không tìm thấy Blade View: {$viewPath}");
        }

        $content = file_get_contents($fullPath);

        // Trích xuất layout @extends
        $layout = 'layouts.app';
        if (preg_match('/@extends\([\'"](.+?)[\'"]\)/', $content, $matches)) {
            $layout = $matches[1];
            $content = str_replace($matches[0], '', $content);
        }

        // Trích xuất title @section('title', '...')
        $pageTitle = 'Contacts Hub - Quản Lý Danh Bạ';
        if (preg_match('/@section\([\'"]title[\'"]\s*,\s*[\'"](.*?)[\'"]\)/', $content, $matches)) {
            $pageTitle = $matches[1];
            $content = str_replace($matches[0], '', $content);
        }

        // Trích xuất content @section('content') ... @endsection
        $sectionContent = $content;
        if (preg_match('/@section\([\'"]content[\'"]\)(.*?)@endsection/s', $content, $matches)) {
            $sectionContent = $matches[1];
        }

        // Đọc layout
        $layoutPath = __DIR__ . '/../resources/views/' . str_replace('.', '/', $layout) . '.blade.php';
        $layoutTemplate = file_exists($layoutPath) ? file_get_contents($layoutPath) : '@yield("content")';

        // Ghép view vào layout
        $compiled = str_replace("@yield('content')", $sectionContent, $layoutTemplate);
        $compiled = str_replace("@yield('title', 'Quản Lý Danh Bạ - Laravel Contacts')", $pageTitle, $compiled);
        $compiled = str_replace("@yield('title')", $pageTitle, $compiled);

        // Biên dịch Blade Directives
        $compiled = preg_replace('/@csrf/', '<input type="hidden" name="_token" value="' . $csrf_token . '">', $compiled);
        $compiled = preg_replace('/@method\([\'"](.+?)[\'"]\)/', '<input type="hidden" name="_method" value="$1">', $compiled);

        // Dịch @if(session('success'))
        $compiled = preg_replace('/@if\(\s*session\([\'"]([a-zA-Z0-9_]+)[\'"]\)\s*\)/', '<?php if (!empty($_SESSION[\'_flash\'][\'$1\'])): ?>', $compiled);
        $compiled = preg_replace('/{{\s*session\([\'"]([a-zA-Z0-9_]+)[\'"]\)\s*}}/', '<?= htmlspecialchars($_SESSION[\'_flash\'][\'$1\'] ?? "", ENT_QUOTES, "UTF-8") ?>', $compiled);

        // Dịch @if, @elseif, @else, @endif (hỗ trợ ngoặc đơn lồng nhau)
        $compiled = preg_replace('/@if\s*\(((?:[^()]+|\([^()]*\))*)\)/', '<?php if ($1): ?>', $compiled);
        $compiled = preg_replace('/@elseif\s*\(((?:[^()]+|\([^()]*\))*)\)/', '<?php elseif ($1): ?>', $compiled);
        $compiled = preg_replace('/@else/', '<?php else: ?>', $compiled);
        $compiled = preg_replace('/@endif/', '<?php endif; ?>', $compiled);

        // Dịch @foreach, @endforeach
        $compiled = preg_replace('/@foreach\s*\(((?:[^()]+|\([^()]*\))*)\)/', '<?php foreach ($1): ?>', $compiled);
        $compiled = preg_replace('/@endforeach/', '<?php endforeach; ?>', $compiled);

        // Dịch @php, @endphp
        $compiled = preg_replace('/@php/', '<?php ', $compiled);
        $compiled = preg_replace('/@endphp/', ' ?>', $compiled);

        // Dịch echo {{ ... }}
        $compiled = preg_replace('/{{\s*(.+?)\s*}}/', '<?= htmlspecialchars((string)($1), ENT_QUOTES, "UTF-8") ?>', $compiled);
        // Dịch raw {!! ... !!}
        $compiled = preg_replace('/{!!\s*(.+?)\s*!!}/', '<?= ($1) ?>', $compiled);

        // Lưu cache tạm và nạp
        $tempDir = __DIR__ . '/../storage/views';
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        $cacheFile = $tempDir . '/' . md5($viewPath) . '.php';
        file_put_contents($cacheFile, $compiled);

        // Thực thi view
        require $cacheFile;

        // Xóa flash message sau khi render
        unset($_SESSION['_flash']);
    }

    public static function csrfToken(): string {
        if (empty($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_token'];
    }

    public static function validateCsrf(): bool {
        $token = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
        return !empty($token) && !empty($_SESSION['_token']) && hash_equals($_SESSION['_token'], $token);
    }
}
