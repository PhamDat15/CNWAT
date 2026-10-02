-- ========================================================
-- HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
-- BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 13 - 16
-- DATABASE SCRIPT: LAPTOP SHOP E-COMMERCE
-- ========================================================

CREATE DATABASE IF NOT EXISTS laptop_shop CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE laptop_shop;

DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- 1. Bảng USERS (Quản lý quản trị viên & người dùng)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    birthday DATE,
    address VARCHAR(200),
    image VARCHAR(100) DEFAULT 'avatar.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2. Bảng CATEGORIES (Hãng máy tính)
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cat_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Bảng PRODUCTS (Sản phẩm laptop)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cat_id INT NOT NULL,
    product_name VARCHAR(200) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    image VARCHAR(100) DEFAULT 'dell_vostro.jpg',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cat_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Chèn dữ liệu Users mẫu
INSERT INTO users (username, password, fullname, birthday, address, image) VALUES
('admin', 'admin', 'Phạm Tiến Đạt', '2002-05-19', 'Học Viện Kỹ Thuật Mật Mã, Hà Nội', 'avatar.jpg'),
('u1', '123456', 'Nguyễn Quốc Bảo', '1998-04-12', 'Cầu Giấy, Hà Nội', '1.jpg'),
('u2', '123456', 'Phạm Hoàng Long', '2000-09-20', 'Quận 1, TP. Hồ Chí Minh', '2.jpg'),
('u3', '123456', 'Trần Thủ Độ', '1995-11-05', 'Hải Châu, Đà Nẵng', '3.jpg');

-- Chèn dữ liệu Hãng Laptop
INSERT INTO categories (id, cat_name, description) VALUES
(1, 'Laptop DELL', 'Dòng máy tính xách tay bền bỉ, hiệu năng văn phòng và gaming'),
(2, 'Laptop HP-Compaq', 'Thiết kế sang trọng, độ bền cao và bảo mật phần cứng'),
(3, 'Laptop SONY VAIO', 'Đẳng cấp thời thượng, màn hình sắc nét vượt trội'),
(4, 'Laptop LENOVO', 'Bàn phím trứ danh ThinkPad, hiệu suất bền bỉ chuyên lập trình'),
(5, 'Laptop ACER', 'Cấu hình mạnh mẽ trong tầm giá, tản nhiệt tối ưu'),
(6, 'Laptop ASUS', 'Mỏng nhẹ ZenBook, công nghệ màn hình OLED tiên tiến'),
(7, 'Laptop MACBOOK', 'Hệ sinh thái Apple sang trọng, chip Apple Silicon siêu tốc');

-- Chèn dữ liệu Sản phẩm Laptop mẫu
INSERT INTO products (cat_id, product_name, price, image, description, created_at) VALUES
(1, 'Laptop Dell Vostro 1014 (Core 2 Duo T6670 / 2.2GHz)', 8699000, 'dell_vostro.jpg', 'CPU Intel Core 2 Duo T6670 2.2GHz, RAM 2GB DDR2, HDD 500GB, Màn hình 14.1 WLED, Pin 6-cell, Trọng lượng 2.1kg.', NOW()),
(1, 'Laptop Dell Vostro V3300 (Core i3-350M / 2.26GHz)', 10990000, 'dell_vostro.jpg', 'CPU Intel Core i3 350M 2.26GHz, RAM 4GB DDR3, Ổ cứng 500GB, Vỏ nhôm nguyên khối siêu bền, Card màn hình rời.', NOW()),
(2, 'Laptop HP Compaq CQ42 (Core i5-450M / 2.4GHz)', 9890000, 'hp_compaq.jpg', 'CPU Intel Core i5 450M 2.4GHz, RAM 4GB, HDD 500GB, Màn hình 14 inch HD BrightView, Thiết kế hoa văn chống bám vân tay.', NOW()),
(2, 'Laptop HP ProBook 450 G8 (Core i5 1135G7)', 15500000, 'hp_compaq.jpg', 'CPU Intel Core i5 thế hệ 11, RAM 8GB DDR4, SSD 512GB NVMe, Màn hình 15.6 inch FHD IPS, Vỏ nhôm cao cấp.', NOW()),
(4, 'Laptop Lenovo ThinkPad T480s (Core i7 / 16GB RAM)', 14200000, 'lenovo_thinkpad.jpg', 'Dòng máy lập trình viên ưa chuộng, siêu nhẹ 1.3kg, bàn phím gõ êm, pin kép sử dụng liên tục 10 tiếng.', NOW()),
(4, 'Laptop Lenovo Legion 5 Gaming (Ryzen 7 / RTX 3060)', 24500000, 'lenovo_thinkpad.jpg', 'Cỗ máy chiến game đỉnh cao, tản nhiệt Coldfront 2.0, màn hình 165Hz chuẩn màu 100% sRGB.', NOW()),
(6, 'Laptop ASUS ZenBook UX425 OLED (Core i7 / 16GB)', 21990000, 'asus_zenbook.jpg', 'Màn hình OLED 2.8K siêu rực rỡ, thời lượng pin 15 giờ, trọng lượng chỉ 1.17kg, bảo mật nhận diện khuôn mặt.', NOW()),
(6, 'Laptop ASUS ROG Strix G15 (Ryzen 9 / RTX 3070)', 31900000, 'asus_zenbook.jpg', 'Laptop chuyên đồ họa và render 3D, đèn LED Aura Sync RGB đa vùng, tản nhiệt kim loại lỏng Liquid Metal.', NOW()),
(7, 'Apple MacBook Pro 14 M3 (18GB RAM / 512GB SSD)', 49990000, 'macbook_pro.jpg', 'Chip M3 Pro tối tân, màn hình Liquid Retina XDR 120Hz ProMotion, pin 22 giờ, cổng kết nối MagSafe & HDMI.', NOW()),
(7, 'Apple MacBook Air M2 (8GB RAM / 256GB SSD)', 24900000, 'macbook_pro.jpg', 'Thiết kế nguyên khối siêu mỏng nhẹ 1.24kg, không quạt tản nhiệt tuyệt đối êm ái, màu Midnight sang trọng.', NOW()),
(5, 'Laptop Acer Aspire 7 Gaming (Core i5 / GTX 1650)', 16490000, 'acer_aspire.jpg', 'Laptop gaming quốc dân, hiệu năng ổn định, bản lề mở 180 độ, Wi-Fi 6 siêu tốc.', NOW());
