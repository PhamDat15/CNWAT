-- ========================================================
-- HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
-- BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 12
-- DATABASE SCRIPT: CLASSES & STUDENTS
-- ========================================================

CREATE DATABASE IF NOT EXISTS school_db CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE school_db;

DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS classes;

CREATE TABLE classes (
    ID VARCHAR(20) PRIMARY KEY,
    ClassName VARCHAR(100) NOT NULL,
    ClassDescription VARCHAR(255),
    NumOfStudents INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE students (
    ID VARCHAR(20) PRIMARY KEY,
    StudentName VARCHAR(100) NOT NULL,
    StudentGender VARCHAR(10),
    StudentAddress VARCHAR(200),
    StudentImage VARCHAR(100),
    ClassID VARCHAR(20),
    FOREIGN KEY (ClassID) REFERENCES classes(ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Chèn dữ liệu mẫu các lớp
INSERT INTO classes (ID, ClassName, ClassDescription, NumOfStudents) VALUES
('PHP001', 'Lập trình PHP & MySQL Chuyên Sâu', 'Lớp chuyên đề bảo mật ứng dụng web', 3),
('0908M', 'Khoa học Máy tính K19', 'Lớp chuyên ngành kỹ thuật', 2),
('0908L', 'Mạng Máy tính & Truyền thông', 'Lớp chuyên đề giao thức mạng', 1),
('09A3G', 'An Toàn Thông Tin 20A', 'Lớp ATTT chính quy Học Viện KMA', 2),
('09A1H', 'Hệ thống Thông tin An toàn', 'Lớp kiến trúc phần mềm an toàn', 1);

-- Chèn dữ liệu mẫu sinh viên
INSERT INTO students (ID, StudentName, StudentGender, StudentAddress, StudentImage, ClassID) VALUES
('SV01', 'Nguyen Trai', 'Nam', 'Hai Duong', '1.jpg', 'PHP001'),
('SV02', 'Nguyen Du', 'Nam', 'Hue', '2.jpg', 'PHP001'),
('SV03', 'Ho Xuan Huong', 'Nu', 'Viet Nam', '3.jpg', 'PHP001'),
('SV04', 'Pham Tien Dat', 'Nam', 'Ha Noi', 'avatar.jpg', '09A3G'),
('SV05', 'Tran Thu Do', 'Nam', 'Thai Binh', '4.jpg', '09A3G'),
('SV06', 'Le Loi', 'Nam', 'Thanh Hoa', '1.jpg', '0908M'),
('SV07', 'Vo Thi Sau', 'Nu', 'Ba Ria', '3.jpg', '0908M'),
('SV08', 'Quang Trung', 'Nam', 'Binh Dinh', '2.jpg', '0908L'),
('SV09', 'Chu Van An', 'Nam', 'Ha Noi', '1.jpg', '09A1H');
