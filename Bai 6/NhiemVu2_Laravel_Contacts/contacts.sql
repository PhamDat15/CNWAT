-- ==============================================================
-- DATABASE: contacts_laravel
-- HỌC PHẦN: CÔNG NGHỆ WEB AN TOÀN - NHIỆM VỤ 6.2 (LARAVEL)
-- SINH VIÊN: PHẠM TIẾN ĐẠT - MSSV: AT200311 - LỚP: AT20A
-- HỌC VIỆN KỸ THUẬT MẬT MÃ (KMA)
-- ==============================================================

CREATE DATABASE IF NOT EXISTS `contacts_laravel` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `contacts_laravel`;

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DỮ LIỆU MẪU BAN ĐẦU (SEED DATA)
INSERT INTO `contacts` (`name`, `phone`, `email`, `address`, `category`, `birthdate`, `notes`, `avatar`, `created_at`) VALUES
('TS. Nguyễn Văn Hùng', '0912345678', 'hungnv@kma.edu.vn', 'Khoa An Toàn Thông Tin, Học viện Kỹ thuật Mật mã', 'Công việc', '1982-05-15', 'Giảng viên hướng dẫn đồ án tốt nghiệp và nghiên cứu khoa học an toàn thông tin.', NULL, NOW()),
('Phạm Tiến Đạt', '0988776655', 'datpt@kma.edu.vn', 'Hà Nội, Việt Nam', 'Gia đình', '2004-10-20', 'Tác giả đồ án - MSSV: AT200311, Lớp AT20A.', NULL, NOW()),
('Trần Hoàng Minh', '0978123456', 'minhth@gmail.com', '141 Chiến Thắng, Tân Triều, Thanh Trì, Hà Nội', 'Bạn bè', '2004-03-12', 'Bạn cùng lớp AT20A, nhóm trưởng bài tập lớn môn Mạng máy tính.', NULL, NOW()),
('Lê Thị Mai Anh', '0936998877', 'maianh.le@fpt.com.vn', 'Cầu Giấy, Hà Nội', 'Đối tác', '2001-08-25', 'Quản lý tuyển dụng nhân sự tập đoàn FPT Software, liên hệ thực tập sinh Pentest.', NULL, NOW()),
('Vũ Quốc Bảo', '0904556677', 'baovq@techcombank.com.vn', 'Hoàn Kiếm, Hà Nội', 'Khách hàng', '1995-12-05', 'Khách hàng tư vấn giải pháp kiểm thử xâm nhập bảo mật cổng thanh toán điện tử.', NULL, NOW()),
('Nguyễn Hải Yến', '0982334455', 'haiyen.nguyen@gmail.com', 'Hà Đông, Hà Nội', 'Bạn bè', '2004-11-30', 'Học cùng khóa KMA, thành viên CLB An toàn thông tin KMA Security Club.', NULL, NOW());
