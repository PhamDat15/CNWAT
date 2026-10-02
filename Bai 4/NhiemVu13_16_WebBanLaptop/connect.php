<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 13-16: CONNECT.PHP
// ========================================================

$host = "localhost";
$user = "root";
$pass = "";
$db   = "laptop_shop";

$conn = @mysqli_connect($host, $user, $pass, $db);
if ($conn) {
    mysqli_set_charset($conn, "utf8");
}

// Dữ liệu mẫu dự phòng khi chưa cấu hình MySQL
$SAMPLE_CATEGORIES = [
    1 => ['id' => 1, 'cat_name' => 'Laptop DELL'],
    2 => ['id' => 2, 'cat_name' => 'Laptop HP-Compaq'],
    3 => ['id' => 3, 'cat_name' => 'Laptop SONY VAIO'],
    4 => ['id' => 4, 'cat_name' => 'Laptop LENOVO'],
    5 => ['id' => 5, 'cat_name' => 'Laptop ACER'],
    6 => ['id' => 6, 'cat_name' => 'Laptop ASUS'],
    7 => ['id' => 7, 'cat_name' => 'Laptop MACBOOK']
];

$SAMPLE_PRODUCTS = [
    1 => [
        'id' => 1,
        'cat_id' => 1,
        'product_name' => 'Laptop Dell Vostro 1014 (Core 2 Duo T6670 / 2.2GHz)',
        'price' => 8699000,
        'image' => 'dell_vostro.jpg',
        'description' => 'CPU Intel Core 2 Duo T6670 2.2GHz, RAM 2GB DDR2, HDD 500GB, Màn hình 14.1 WLED, Pin 6-cell, Trọng lượng 2.1kg.'
    ],
    2 => [
        'id' => 2,
        'cat_id' => 1,
        'product_name' => 'Laptop Dell Vostro V3300 (Core i3-350M / 2.26GHz)',
        'price' => 10990000,
        'image' => 'dell_vostro.jpg',
        'description' => 'CPU Intel Core i3 350M 2.26GHz, RAM 4GB DDR3, Ổ cứng 500GB, Vỏ nhôm nguyên khối siêu bền, Card màn hình rời.'
    ],
    3 => [
        'id' => 3,
        'cat_id' => 2,
        'product_name' => 'Laptop HP Compaq CQ42 (Core i5-450M / 2.4GHz)',
        'price' => 9890000,
        'image' => 'hp_compaq.jpg',
        'description' => 'CPU Intel Core i5 450M 2.4GHz, RAM 4GB, HDD 500GB, Màn hình 14 inch HD BrightView, Thiết kế hoa văn chống bám vân tay.'
    ],
    4 => [
        'id' => 4,
        'cat_id' => 4,
        'product_name' => 'Laptop Lenovo ThinkPad T480s (Core i7 / 16GB RAM)',
        'price' => 14200000,
        'image' => 'lenovo_thinkpad.jpg',
        'description' => 'Dòng máy lập trình viên ưa chuộng, siêu nhẹ 1.3kg, bàn phím gõ êm, pin kép sử dụng liên tục 10 tiếng.'
    ],
    5 => [
        'id' => 5,
        'cat_id' => 6,
        'product_name' => 'Laptop ASUS ZenBook UX425 OLED (Core i7 / 16GB)',
        'price' => 21990000,
        'image' => 'asus_zenbook.jpg',
        'description' => 'Màn hình OLED 2.8K siêu rực rỡ, thời lượng pin 15 giờ, trọng lượng chỉ 1.17kg, bảo mật nhận diện khuôn mặt.'
    ],
    6 => [
        'id' => 6,
        'cat_id' => 7,
        'product_name' => 'Apple MacBook Pro 14 M3 (18GB RAM / 512GB SSD)',
        'price' => 49990000,
        'image' => 'macbook_pro.jpg',
        'description' => 'Chip M3 Pro tối tân, màn hình Liquid Retina XDR 120Hz ProMotion, pin 22 giờ, cổng kết nối MagSafe & HDMI.'
    ]
];
?>
