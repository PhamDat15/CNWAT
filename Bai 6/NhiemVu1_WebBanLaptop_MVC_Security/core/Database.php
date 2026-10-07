<?php
/**
 * Database Connection Manager (PDO)
 * Hỗ trợ MySQL (XAMPP mặc định) và tự động Fallback sang SQLite nếu MySQL chưa khởi chạy.
 * Đảm bảo 100% Prepared Statements chống tấn công SQL Injection.
 */

class Database {
    private static ?PDO $instance = null;
    private static string $driver = 'mysql';

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            self::$instance = self::createConnection();
        }
        return self::$instance;
    }

    public static function getDriver(): string {
        return self::$driver;
    }

    private static function createConnection(): PDO {
        $host = '127.0.0.1';
        $dbName = 'laptop_mvc_shop';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        // 1. Thử kết nối MySQL trước
        try {
            // Kiểm tra xem database đã tồn tại chưa, nếu chưa thì tạo
            $initPdo = new PDO("mysql:host={$host};charset={$charset}", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 2
            ]);
            $initPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            
            $pdo = new PDO("mysql:host={$host};dbname={$dbName};charset={$charset}", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            self::$driver = 'mysql';
            self::initTablesIfEmpty($pdo, 'mysql');
            return $pdo;
        } catch (PDOException $e) {
            // 2. Nếu MySQL chưa bật, tự động fallback sang SQLite đảm bảo ứng dụng luôn chạy mượt
            $sqliteDir = __DIR__ . '/../data';
            if (!is_dir($sqliteDir)) {
                mkdir($sqliteDir, 0777, true);
            }
            $sqliteFile = $sqliteDir . '/laptop_mvc.sqlite';
            $pdo = new PDO("sqlite:" . $sqliteFile, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            self::$driver = 'sqlite';
            self::initTablesIfEmpty($pdo, 'sqlite');
            return $pdo;
        }
    }

    private static function initTablesIfEmpty(PDO $pdo, string $driver): void {
        try {
            $checkTable = ($driver === 'mysql') 
                ? "SHOW TABLES LIKE 'products'" 
                : "SELECT name FROM sqlite_master WHERE type='table' AND name='products'";
            $stmt = $pdo->query($checkTable);
            if ($stmt->fetch()) {
                return; // Đã có bảng
            }

            if ($driver === 'mysql') {
                $pdo->exec("
                    CREATE TABLE IF NOT EXISTS `users` (
                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                        `username` VARCHAR(50) NOT NULL UNIQUE,
                        `password` VARCHAR(255) NOT NULL,
                        `fullname` VARCHAR(100) NOT NULL,
                        `email` VARCHAR(100) NOT NULL UNIQUE,
                        `role` VARCHAR(20) NOT NULL DEFAULT 'customer',
                        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

                    CREATE TABLE IF NOT EXISTS `categories` (
                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                        `name` VARCHAR(50) NOT NULL UNIQUE,
                        `description` VARCHAR(255) NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

                    CREATE TABLE IF NOT EXISTS `products` (
                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                        `name` VARCHAR(150) NOT NULL,
                        `brand` VARCHAR(50) NOT NULL,
                        `price` DECIMAL(12, 2) NOT NULL,
                        `old_price` DECIMAL(12, 2) NULL,
                        `quantity` INT NOT NULL DEFAULT 10,
                        `image` VARCHAR(255) NOT NULL,
                        `short_desc` TEXT NULL,
                        `description` LONGTEXT NULL,
                        `specs_cpu` VARCHAR(100) NULL,
                        `specs_ram` VARCHAR(50) NULL,
                        `specs_storage` VARCHAR(50) NULL,
                        `specs_screen` VARCHAR(100) NULL,
                        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

                    CREATE TABLE IF NOT EXISTS `orders` (
                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                        `user_id` INT NULL,
                        `customer_name` VARCHAR(100) NOT NULL,
                        `customer_phone` VARCHAR(20) NOT NULL,
                        `customer_address` TEXT NOT NULL,
                        `customer_notes` TEXT NULL,
                        `total_amount` DECIMAL(12,2) NOT NULL,
                        `status` VARCHAR(30) NOT NULL DEFAULT 'pending',
                        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

                    CREATE TABLE IF NOT EXISTS `order_items` (
                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                        `order_id` INT NOT NULL,
                        `product_id` INT NOT NULL,
                        `product_name` VARCHAR(150) NOT NULL,
                        `price` DECIMAL(12,2) NOT NULL,
                        `quantity` INT NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                ");
            } else {
                // SQLite
                $pdo->exec("
                    CREATE TABLE IF NOT EXISTS users (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        username TEXT NOT NULL UNIQUE,
                        password TEXT NOT NULL,
                        fullname TEXT NOT NULL,
                        email TEXT NOT NULL UNIQUE,
                        role TEXT NOT NULL DEFAULT 'customer',
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                    );

                    CREATE TABLE IF NOT EXISTS categories (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        name TEXT NOT NULL UNIQUE,
                        description TEXT
                    );

                    CREATE TABLE IF NOT EXISTS products (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        name TEXT NOT NULL,
                        brand TEXT NOT NULL,
                        price REAL NOT NULL,
                        old_price REAL,
                        quantity INTEGER NOT NULL DEFAULT 10,
                        image TEXT NOT NULL,
                        short_desc TEXT,
                        description TEXT,
                        specs_cpu TEXT,
                        specs_ram TEXT,
                        specs_storage TEXT,
                        specs_screen TEXT,
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                    );

                    CREATE TABLE IF NOT EXISTS orders (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        user_id INTEGER,
                        customer_name TEXT NOT NULL,
                        customer_phone TEXT NOT NULL,
                        customer_address TEXT NOT NULL,
                        customer_notes TEXT,
                        total_amount REAL NOT NULL,
                        status TEXT NOT NULL DEFAULT 'pending',
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                    );

                    CREATE TABLE IF NOT EXISTS order_items (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        order_id INTEGER NOT NULL,
                        product_id INTEGER NOT NULL,
                        product_name TEXT NOT NULL,
                        price REAL NOT NULL,
                        quantity INTEGER NOT NULL
                    );
                ");
            }

            // Seed Users (Admin: admin / 123456, Customer: customer / 123456)
            $adminPass = password_hash('123456', PASSWORD_BCRYPT);
            $custPass = password_hash('123456', PASSWORD_BCRYPT);

            $stmtUser = $pdo->prepare("INSERT INTO users (username, password, fullname, email, role) VALUES (?, ?, ?, ?, ?)");
            $stmtUser->execute(['admin', $adminPass, 'Quản Trị Viên (Admin)', 'admin@kma.edu.vn', 'admin']);
            $stmtUser->execute(['customer', $custPass, 'Phạm Tiến Đạt (Khách hàng)', 'datpt@kma.edu.vn', 'customer']);

            // Seed Categories
            $stmtCat = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
            $brands = [
                ['Dell', 'Dòng laptop văn phòng và đồ họa cao cấp bền bỉ'],
                ['Asus', 'Laptop thời trang cao cấp ZenBook và Gaming ROG'],
                ['HP', 'Thiết kế sang trọng, hiệu năng ổn định'],
                ['Apple', 'MacBook đẳng cấp chip Apple Silicon siêu mạnh'],
                ['Lenovo', 'Bàn phím gõ tốt nhất thế giới, ThinkPad huyền thoại'],
                ['Acer', 'Cấu hình cao, tối ưu chi phí học sinh sinh viên']
            ];
            foreach ($brands as $b) {
                $stmtCat->execute($b);
            }

            // Seed Products
            $products = [
                [
                    'Dell Vostro 5410 Core i5', 'Dell', 18990000, 20990000, 15, 'dell_vostro.jpg',
                    'Laptop mỏng nhẹ kim loại nguyên khối, bảo mật vân tay, hiệu năng văn phòng mượt mà.',
                    '<p><strong>Dell Vostro 5410</strong> mang đến trải nghiệm làm việc đỉnh cao với vi xử lý Intel Core i5 thế hệ mới, bộ nhớ RAM DDR4 tốc độ cao giúp đa nhiệm mượt mà. Màn hình 14 inch Full HD viền siêu mỏng chống chói cho góc nhìn sắc nét.</p>',
                    'Intel Core i5-11320H 3.2GHz', '16GB DDR4 3200MHz', '512GB NVMe SSD', '14.0 inch Full HD IPS'
                ],
                [
                    'Dell XPS 13 Plus 9320 Core i7', 'Dell', 34500000, 37900000, 8, 'dell_vostro.jpg',
                    'Tuyệt tác Ultrabook tương lai với bàn phím tràn viền cảm ứng tàng hình.',
                    '<p><strong>Dell XPS 13 Plus</strong> đại diện cho ngôn ngữ thiết kế tối giản sang trọng bậc nhất thế giới. Màn hình OLED 3.5K rực rỡ, cảm ứng Touch Bar điện dung và bộ xử lý Core i7 cực mạnh mẽ.</p>',
                    'Intel Core i7-1360P 12 Cores', '32GB LPDDR5 6000MHz', '1TB NVMe PCIe Gen4', '13.4 inch 3.5K OLED Touch'
                ],
                [
                    'Asus ZenBook 14 OLED UX3402', 'Asus', 22490000, 24900000, 12, 'asus_zenbook.jpg',
                    'Màn hình OLED 2.8K 90Hz siêu đẹp, chuẩn màu 100% DCI-P3, pin 75Wh trâu bò.',
                    '<p><strong>Asus ZenBook 14 OLED</strong> sở hữu thiết kế lấy cảm hứng từ nghệ thuật gốm Kintsugi truyền thống Nhật Bản. Trọng lượng chỉ 1.39kg, hỗ trợ âm thanh Dolby Atmos Harman Kardon cao cấp.</p>',
                    'Intel Core i5-1340P 12 Nhân', '16GB LPDDR5', '512GB PCIe 4.0 SSD', '14.0 inch 2.8K 90Hz OLED'
                ],
                [
                    'Asus ROG Zephyrus G14 Gaming', 'Asus', 39990000, 43900000, 5, 'asus_zenbook.jpg',
                    'Laptop Gaming đồ họa mỏng nhẹ đỉnh cao với màn hình AniMe Matrix LED độc đáo.',
                    '<p><strong>ROG Zephyrus G14</strong> trang bị card đồ họa RTX 4060 cùng chip Ryzen 9 mạnh mẽ, tản nhiệt buồng hơi kim loại lỏng Liquid Metal siêu mát.</p>',
                    'AMD Ryzen 9 7940HS', '32GB DDR5 4800MHz', '1TB PCIe 4.0 NVMe', '14.0 inch QHD+ 165Hz ROG Nebula'
                ],
                [
                    'MacBook Pro 14 M3 Pro 18GB', 'Apple', 48990000, 52900000, 10, 'macbook_pro.jpg',
                    'Sức mạnh xử lý AI và Render đồ họa đỉnh cao với chip Apple M3 Pro thế hệ mới.',
                    '<p><strong>MacBook Pro 14 inch</strong> với chip Apple M3 Pro đem lại bước nhảy vọt về hiệu năng đồ họa Ray Tracing phần cứng. Màn hình Liquid Retina XDR 120Hz ProMotion 1600 nits siêu sáng, thời lượng pin lên đến 22 giờ liên tục.</p>',
                    'Apple M3 Pro 11-Core CPU, 14-Core GPU', '18GB Unified Memory', '512GB Ultra-fast SSD', '14.2 inch Liquid Retina XDR 120Hz'
                ],
                [
                    'MacBook Air M2 13.6 inch 256GB', 'Apple', 24990000, 27900000, 20, 'macbook_pro.jpg',
                    'Thiết kế nhôm nguyên khối siêu mỏng 11.3mm, trọng lượng 1.24kg cực kỳ thanh thoát.',
                    '<p><strong>MacBook Air M2</strong> thiết kế hoàn toàn mới với sạc MagSafe 3 an toàn, màn hình tai thỏ Liquid Retina hiển thị 1 tỷ màu và bàn phím Magic Keyboard gõ cực êm ái.</p>',
                    'Apple M2 8-Core CPU, 8-Core GPU', '8GB Unified Memory', '256GB SSD', '13.6 inch Liquid Retina True Tone'
                ],
                [
                    'HP Envy x360 2-in-1 14 inch', 'HP', 20490000, 22900000, 14, 'hp_compaq.jpg',
                    'Laptop xoay gập 360 độ kèm bút cảm ứng HP Stylus, khung nhôm bóng bẩy tinh tế.',
                    '<p><strong>HP Envy x360</strong> cho phép biến hóa linh hoạt giữa chế độ Laptop, Lều xem phim và Máy tính bảng ghi chú vẽ đồ họa chuyên nghiệp. Tích hợp loa Bang & Olufsen âm thanh vòm sống động.</p>',
                    'Intel Core i5-1335U 10 Cores', '16GB DDR4 3200MHz', '512GB PCIe NVMe M.2', '14.0 inch FHD IPS Cảm ứng Đa điểm'
                ],
                [
                    'Lenovo ThinkPad X1 Carbon Gen 11', 'Lenovo', 42990000, 46900000, 7, 'lenovo_thinkpad.jpg',
                    'Huyền thoại doanh nhân siêu bền chuẩn quân đội MIL-STD-810H, trọng lượng chỉ 1.12kg.',
                    '<p><strong>ThinkPad X1 Carbon Gen 11</strong> gia cố từ sợi carbon cao cấp, bàn phím gõ sâu 1.5mm chống mỏi tay tuyệt đối, TrackPoint đỏ huyền thoại và bảo mật ThinkShield cấp độ doanh nghiệp.</p>',
                    'Intel Core i7-1365U vPro', '32GB LPDDR5 6400MHz', '1TB PCIe Gen4 SSD', '14.0 inch 2.8K OLED HDR 500'
                ],
                [
                    'Acer Aspire 5 A515 Gaming & Office', 'Acer', 14990000, 16990000, 25, 'acer_aspire.jpg',
                    'Cấu hình quốc dân cho sinh viên kỹ thuật: Core i5 thế hệ 13, tản nhiệt kép TwinAir.',
                    '<p><strong>Acer Aspire 5</strong> sở hữu màn hình 15.6 inch rộng rãi, bàn phím số đầy đủ thích hợp nhập liệu, pin bền bỉ và hỗ trợ nâng cấp dung lượng dễ dàng.</p>',
                    'Intel Core i5-13420H 8 Cores', '16GB DDR4 (Nâng cấp tối đa 32GB)', '512GB NVMe SSD', '15.6 inch FHD IPS ComfyView'
                ]
            ];

            $stmtProd = $pdo->prepare("
                INSERT INTO products (name, brand, price, old_price, quantity, image, short_desc, description, specs_cpu, specs_ram, specs_storage, specs_screen)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            foreach ($products as $p) {
                $stmtProd->execute($p);
            }
        } catch (PDOException $ex) {
            // Log error
            error_log("Database initialization error: " . $ex->getMessage());
        }
    }
}
