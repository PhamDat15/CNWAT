-- ========================================================
-- HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
-- BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 11
-- DATABASE SCRIPT: QUANLYHOCSINH.SQL
-- ========================================================

CREATE DATABASE IF NOT EXISTS quanlyhocsinh CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE quanlyhocsinh;

-- 1. Tạo bảng LOP
DROP TABLE IF EXISTS HOSO;
DROP TABLE IF EXISTS LOP;

CREATE TABLE LOP (
    MALOP CHAR(6) PRIMARY KEY,
    TENLOP CHAR(50) NOT NULL,
    KHOAHOC INT,
    GVCN CHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2. Tạo bảng HOSO
CREATE TABLE HOSO (
    MAHS CHAR(8) PRIMARY KEY,
    HOTEN CHAR(50) NOT NULL,
    NGAYSINH DATE,
    DIACHI CHAR(150),
    LOP CHAR(6),
    DIEMTOAN FLOAT,
    DIEMLY FLOAT,
    DIEMHOA FLOAT,
    FOREIGN KEY (LOP) REFERENCES LOP(MALOP) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Thêm dữ liệu mẫu vào bảng LOP
INSERT INTO LOP (MALOP, TENLOP, KHOAHOC, GVCN) VALUES 
('CNTT1', 'Cong nghe thong tin 1', 15, 'Thay A'),
('KT1', 'Ke toan 1', 15, 'Co B'),
('AT20A', 'An Toan Thong Tin 20A', 20, 'Thay Nguyen Van C'),
('AT20B', 'An Toan Thong Tin 20B', 20, 'Co Le Thi D');

-- 4. Thêm dữ liệu mẫu vào bảng HOSO (> 10 bản ghi để kiểm thử phân trang)
INSERT INTO HOSO (MAHS, HOTEN, NGAYSINH, DIACHI, LOP, DIEMTOAN, DIEMLY, DIEMHOA) VALUES
('HS01', 'Nguyen Van A', '2000-01-01', 'Ha Noi', 'CNTT1', 8.5, 7.0, 9.0),
('HS02', 'Tran Thi B', '2000-02-02', 'Ha Noi', 'CNTT1', 9.0, 8.0, 8.5),
('HS03', 'Le Van C', '2000-03-03', 'Hai Phong', 'KT1', 7.0, 6.5, 5.5),
('HS04', 'Pham Van D', '2000-04-04', 'Nam Dinh', 'CNTT1', 8.0, 8.0, 8.0),
('HS05', 'Do Thi E', '2000-05-05', 'Ha Noi', 'KT1', 9.5, 9.0, 9.5),
('HS06', 'Hoang Van F', '2000-06-06', 'Thai Binh', 'CNTT1', 5.5, 6.0, 7.0),
('HS07', 'Ngo Thi G', '2000-07-07', 'Ha Nam', 'KT1', 6.5, 7.5, 8.0),
('HS08', 'Vu Van H', '2000-08-08', 'Ninh Binh', 'CNTT1', 8.0, 5.5, 6.5),
('HS09', 'Dang Thi I', '2000-09-09', 'Ha Noi', 'KT1', 9.0, 8.5, 9.0),
('HS10', 'Bui Van K', '2000-10-10', 'Ha Noi', 'CNTT1', 7.5, 7.0, 7.5),
('HS11', 'Ly Thi L', '2000-11-11', 'Ha Noi', 'CNTT1', 8.5, 9.0, 10.0),
('HS12', 'Pham Tien Dat', '2002-05-19', 'Ha Noi', 'AT20A', 9.5, 9.0, 9.8),
('HS13', 'Tran Minh Duc', '2002-08-15', 'Bac Ninh', 'AT20A', 8.5, 8.0, 8.5);
