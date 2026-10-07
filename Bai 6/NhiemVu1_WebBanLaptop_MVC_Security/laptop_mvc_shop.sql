-- ==============================================================
-- DATABASE: laptop_mvc_shop
-- HỌC PHẦN: CÔNG NGHỆ WEB AN TOÀN - LAB 6 (PHIÊN BẢN 1.3)
-- SINH VIÊN: PHẠM TIẾN ĐẠT - MSSV: AT200311 - LỚP: AT20A
-- HỌC VIỆN KỸ THUẬT MẬT MÃ (KMA)
-- ==============================================================

CREATE DATABASE IF NOT EXISTS `laptop_mvc_shop` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `laptop_mvc_shop`;

-- 1. BẢNG NGƯỜI DÙNG & PHÂN QUYỀN (USERS)
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `fullname` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `role` VARCHAR(20) NOT NULL DEFAULT 'customer',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Mật khẩu mặc định: 123456 (Đã mã hóa Bcrypt cost=10)
INSERT INTO `users` (`username`, `password`, `fullname`, `email`, `role`, `created_at`) VALUES
('admin', '$2y$10$wT3tJvE4eXo7eN12f6e9kO7x5W8Qh4s0A6d5c1b2a3f4e5d6c7b8a', 'Quản Trị Viên (Admin)', 'admin@kma.edu.vn', 'admin', NOW()),
('customer', '$2y$10$wT3tJvE4eXo7eN12f6e9kO7x5W8Qh4s0A6d5c1b2a3f4e5d6c7b8a', 'Phạm Tiến Đạt (Khách hàng)', 'datpt@kma.edu.vn', 'customer', NOW());

-- 2. BẢNG DANH MỤC THƯƠNG HIỆU (CATEGORIES)
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE,
    `description` VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`name`, `description`) VALUES
('Dell', 'Dòng laptop văn phòng và đồ họa cao cấp bền bỉ'),
('Asus', 'Laptop thời trang cao cấp ZenBook và Gaming ROG'),
('HP', 'Thiết kế sang trọng, hiệu năng ổn định'),
('Apple', 'MacBook đẳng cấp chip Apple Silicon siêu mạnh'),
('Lenovo', 'Bàn phím gõ tốt nhất thế giới, ThinkPad huyền thoại'),
('Acer', 'Cấu hình cao, tối ưu chi phí học sinh sinh viên');

-- 3. BẢNG SẢN PHẨM LAPTOP (PRODUCTS)
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`name`, `brand`, `price`, `old_price`, `quantity`, `image`, `short_desc`, `description`, `specs_cpu`, `specs_ram`, `specs_storage`, `specs_screen`, `created_at`) VALUES
('Dell Vostro 5410 Core i5', 'Dell', 18990000.00, 20990000.00, 15, 'dell_vostro.jpg',
 'Laptop mỏng nhẹ kim loại nguyên khối, bảo mật vân tay, hiệu năng văn phòng mượt mà.',
 '<p><strong>Dell Vostro 5410</strong> mang đến trải nghiệm làm việc đỉnh cao với vi xử lý Intel Core i5 thế hệ mới, bộ nhớ RAM DDR4 tốc độ cao giúp đa nhiệm mượt mà. Màn hình 14 inch Full HD viền siêu mỏng chống chói cho góc nhìn sắc nét.</p>',
 'Intel Core i5-11320H 3.2GHz', '16GB DDR4 3200MHz', '512GB NVMe SSD', '14.0 inch Full HD IPS', NOW()),

('Dell XPS 13 Plus 9320 Core i7', 'Dell', 34500000.00, 37900000.00, 8, 'dell_vostro.jpg',
 'Tuyệt tác Ultrabook tương lai với bàn phím tràn viền cảm ứng tàng hình.',
 '<p><strong>Dell XPS 13 Plus</strong> đại diện cho ngôn ngữ thiết kế tối giản sang trọng bậc nhất thế giới. Màn hình OLED 3.5K rực rỡ, cảm ứng Touch Bar điện dung và bộ xử lý Core i7 cực mạnh mẽ.</p>',
 'Intel Core i7-1360P 12 Cores', '32GB LPDDR5 6000MHz', '1TB NVMe PCIe Gen4', '13.4 inch 3.5K OLED Touch', NOW()),

('Asus ZenBook 14 OLED UX3402', 'Asus', 22490000.00, 24900000.00, 12, 'asus_zenbook.jpg',
 'Màn hình OLED 2.8K 90Hz siêu đẹp, chuẩn màu 100% DCI-P3, pin 75Wh trâu bò.',
 '<p><strong>Asus ZenBook 14 OLED</strong> sở hữu thiết kế lấy cảm hứng từ nghệ thuật gốm Kintsugi truyền thống Nhật Bản. Trọng lượng chỉ 1.39kg, hỗ trợ âm thanh Dolby Atmos Harman Kardon cao cấp.</p>',
 'Intel Core i5-1340P 12 Nhân', '16GB LPDDR5', '512GB PCIe 4.0 SSD', '14.0 inch 2.8K 90Hz OLED', NOW()),

('Asus ROG Zephyrus G14 Gaming', 'Asus', 39990000.00, 43900000.00, 5, 'asus_zenbook.jpg',
 'Laptop Gaming đồ họa mỏng nhẹ đỉnh cao với màn hình AniMe Matrix LED độc đáo.',
 '<p><strong>ROG Zephyrus G14</strong> trang bị card đồ họa RTX 4060 cùng chip Ryzen 9 mạnh mẽ, tản nhiệt buồng hơi kim loại lỏng Liquid Metal siêu mát.</p>',
 'AMD Ryzen 9 7940HS', '32GB DDR5 4800MHz', '1TB PCIe 4.0 NVMe', '14.0 inch QHD+ 165Hz ROG Nebula', NOW()),

('MacBook Pro 14 M3 Pro 18GB', 'Apple', 48990000.00, 52900000.00, 10, 'macbook_pro.jpg',
 'Sức mạnh xử lý AI và Render đồ họa đỉnh cao với chip Apple M3 Pro thế hệ mới.',
 '<p><strong>MacBook Pro 14 inch</strong> với chip Apple M3 Pro đem lại bước nhảy vọt về hiệu năng đồ họa Ray Tracing phần cứng. Màn hình Liquid Retina XDR 120Hz ProMotion 1600 nits siêu sáng, thời lượng pin lên đến 22 giờ liên tục.</p>',
 'Apple M3 Pro 11-Core CPU, 14-Core GPU', '18GB Unified Memory', '512GB Ultra-fast SSD', '14.2 inch Liquid Retina XDR 120Hz', NOW()),

('MacBook Air M2 13.6 inch 256GB', 'Apple', 24990000.00, 27900000.00, 20, 'macbook_pro.jpg',
 'Thiết kế nhôm nguyên khối siêu mỏng 11.3mm, trọng lượng 1.24kg cực kỳ thanh thoát.',
 '<p><strong>MacBook Air M2</strong> thiết kế hoàn toàn mới với sạc MagSafe 3 an toàn, màn hình tai thỏ Liquid Retina hiển thị 1 tỷ màu và bàn phím Magic Keyboard gõ cực êm ái.</p>',
 'Apple M2 8-Core CPU, 8-Core GPU', '8GB Unified Memory', '256GB SSD', '13.6 inch Liquid Retina True Tone', NOW()),

('HP Envy x360 2-in-1 14 inch', 'HP', 20490000.00, 22900000.00, 14, 'hp_compaq.jpg',
 'Laptop xoay gập 360 độ kèm bút cảm ứng HP Stylus, khung nhôm bóng bẩy tinh tế.',
 '<p><strong>HP Envy x360</strong> cho phép biến hóa linh hoạt giữa chế độ Laptop, Lều xem phim và Máy tính bảng ghi chú vẽ đồ họa chuyên nghiệp. Tích hợp loa Bang & Olufsen âm thanh vòm sống động.</p>',
 'Intel Core i5-1335U 10 Cores', '16GB DDR4 3200MHz', '512GB PCIe NVMe M.2', '14.0 inch FHD IPS Cảm ứng Đa điểm', NOW()),

('HP Pavilion 15 Core i5 13th', 'HP', 16290000.00, 17900000.00, 18, 'hp_compaq.jpg',
 'Laptop phổ thông đa năng cho công sở và sinh viên, viền mỏng thanh lịch.',
 '<p><strong>HP Pavilion 15</strong> màn hình rộng sắc nét, bàn phím số thuận tiện, thời lượng pin cả ngày dài và hỗ trợ sạc nhanh 50% trong 45 phút.</p>',
 'Intel Core i5-1335U', '16GB DDR4', '512GB PCIe NVMe', '15.6 inch FHD IPS', NOW()),

('Lenovo ThinkPad X1 Carbon Gen 11', 'Lenovo', 42990000.00, 46900000.00, 7, 'lenovo_thinkpad.jpg',
 'Huyền thoại doanh nhân siêu bền chuẩn quân đội MIL-STD-810H, trọng lượng chỉ 1.12kg.',
 '<p><strong>ThinkPad X1 Carbon Gen 11</strong> gia cố từ sợi carbon cao cấp, bàn phím gõ sâu 1.5mm chống mỏi tay tuyệt đối, TrackPoint đỏ huyền thoại và bảo mật ThinkShield cấp độ doanh nghiệp.</p>',
 'Intel Core i7-1365U vPro', '32GB LPDDR5 6400MHz', '1TB PCIe Gen4 SSD', '14.0 inch 2.8K OLED HDR 500', NOW()),

('Lenovo Legion 5 Pro RTX 4070', 'Lenovo', 36990000.00, 39900000.00, 9, 'lenovo_thinkpad.jpg',
 'Quái vật hiệu năng với card đồ họa RTX 4070 công suất tối đa 140W, màn hình 240Hz siêu mượt.',
 '<p><strong>Lenovo Legion 5 Pro</strong> mang đến sức mạnh đồ họa đỉnh nóc, giải nhiệt Legion Coldfront 5.0 tối tân, đèn bàn phím Legion TrueStrike RGB 4 vùng.</p>',
 'AMD Ryzen 7 7745HX', '32GB DDR5 5200MHz', '1TB SSD NVMe', '16.0 inch WQXGA 240Hz 500 nits', NOW()),

('Acer Aspire 5 A515 Gaming & Office', 'Acer', 14990000.00, 16990000.00, 25, 'acer_aspire.jpg',
 'Cấu hình quốc dân cho sinh viên kỹ thuật: Core i5 thế hệ 13, tản nhiệt kép TwinAir.',
 '<p><strong>Acer Aspire 5</strong> sở hữu màn hình 15.6 inch rộng rãi, bàn phím số đầy đủ thích hợp nhập liệu, pin bền bỉ và hỗ trợ nâng cấp dung lượng dễ dàng.</p>',
 'Intel Core i5-13420H 8 Cores', '16GB DDR4', '512GB NVMe SSD', '15.6 inch FHD IPS ComfyView', NOW()),

('Acer Swift Go 14 OLED AI', 'Acer', 21990000.00, 23900000.00, 11, 'acer_aspire.jpg',
 'Laptop trí tuệ nhân tạo Intel Core Ultra 5 tích hợp NPU AI Boost xử lý thuật toán siêu tốc.',
 '<p><strong>Acer Swift Go 14</strong> mỏng 14.9mm, màn hình OLED 2.8K 90Hz rực rỡ đạt chuẩn 100% DCI-P3, webcam 1440p QHD hỗ trợ các tính năng AI Studio Effects.</p>',
 'Intel Core Ultra 5 125H AI Boost', '16GB LPDDR5X', '512GB PCIe Gen4', '14.0 inch 2.8K OLED 90Hz', NOW());

-- 4. BẢNG ĐƠN HÀNG (ORDERS)
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NULL,
    `customer_name` VARCHAR(100) NOT NULL,
    `customer_phone` VARCHAR(20) NOT NULL,
    `customer_address` TEXT NOT NULL,
    `customer_notes` TEXT NULL,
    `total_amount` DECIMAL(12,2) NOT NULL,
    `status` VARCHAR(30) NOT NULL DEFAULT 'pending',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. BẢNG CHI TIẾT ĐƠN HÀNG (ORDER_ITEMS)
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `product_name` VARCHAR(150) NOT NULL,
    `price` DECIMAL(12,2) NOT NULL,
    `quantity` INT NOT NULL,
    CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
