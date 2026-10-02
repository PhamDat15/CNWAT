# BÁO CÁO VÀ HƯỚNG DẪN THỰC HÀNH LAB 4: PHP & CSDL (PHIÊN BẢN 2.1)
**HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN**  
**Học phần:** Công Nghệ Web An Toàn  
**Sinh viên thực hiện:** Phạm Tiến Đạt  
**Mã số sinh viên:** AT200311  
**Lớp:** AT20A  
**Năm học:** 2026  

---

## 1. TỔNG QUAN HỆ THỐNG BÀI THỰC HÀNH 4

Bài thực hành số 4 bao gồm toàn bộ **16 Nhiệm vụ** thực hành lập trình phía máy chủ (Server-side Web Development) với ngôn ngữ **PHP** và hệ quản trị cơ sở dữ liệu **MySQL**, áp dụng các tiêu chuẩn an toàn web, module hóa mã nguồn và tối ưu trải nghiệm người dùng:

| STT | Nhiệm vụ | Thư mục thực thi | Mô tả chức năng chính |
|:---:|:---|:---|:---|
| **01** | **Tạo template** | `NhiemVu01_Template/` | Chia tách bố cục trang thành các thành phần: `Head.php`, `Menu.php`, `Main.php`, `Footer.php` và trang điều phối `index.php` bằng Flexbox. |
| **02** | **Sử dụng template** | `NhiemVu02_SuDungTemplate/` | Ứng dụng template cho các trang chức năng: `register.php`, `result_register.php`, `calculate.php` (tính 10!, diện tích, thể tích, chữ chạy). |
| **03** | **Lấy và gửi dữ liệu** | `NhiemVu03_LayVaGuiDuLieu/` | Kiến trúc điều hướng Switch-case trên nền `index.php`, form vẽ bảng động, máy tính số học, bảng điểm học sinh, ma trận 3x3 và upload 10 files. |
| **04** | **GetForm** | `NhiemVu04_GetForm/` | Thu thập dữ liệu Form toàn diện: Text, Password, Radio, Checkbox array, Select list, Textarea; xử lý cả 2 trang và 1 page `contact1Page.php`. |
| **05** | **Phiên (Session)** | `NhiemVu05_Session/` | Cơ chế xác thực Session bảo mật, phân quyền 2 phân hệ: End User & Protected Admin (`admin/index.php`, `home.php`, `upload.php`, `logout.php`). |
| **06** | **Cookie** | `NhiemVu06_Cookie/` | Ghi nhớ đăng nhập 30 ngày, tự động điền credentials khi truy cập từ lần 2, quản lý danh sách Web Links yêu thích vào Cookie JSON. |
| **07** | **Thư viện Function** | `NhiemVu07_Function/` | Tổ chức thư viện hàm `libs/xuLyMangSo.php`, `libs/xuLyMatran.php`, `libs/math.php`; tính toán mảng 1 chiều và giải tích ma trận vuông. |
| **08** | **Đọc & Ghi file** | `NhiemVu08_DocGhiFile/` | Quản lý sinh viên không dùng RDBMS, lưu trữ cấu trúc 3 dòng/bản ghi trong file `student.txt`, đọc danh sách và ghi nối tiếp (`FILE_APPEND`). |
| **09** | **Data Flow QLSV File** | `NhiemVu09_QuanLyFile_QLSV/` | Quản trị vòng đời dữ liệu hoàn chỉnh (Full CRUD + File Upload) lưu trữ trên file: List, Add, Edit, Detail, Delete và upload ảnh đại diện. |
| **10** | **Website đa ngôn ngữ** | `NhiemVu10_DaNgonNgu/` | Đa ngôn ngữ (Tiếng Việt / English) bằng cách định nghĩa hằng số trong thư mục `lang/`, lưu lựa chọn vào Session và nạp động. |
| **11** | **CSDL Quản lý học sinh** | `NhiemVu11_CSDL_QuanLyHocSinh/` | MySQL Database `quanlyhocsinh`: Quản lý 2 bảng `LOP` và `HOSO`, kiểm soát khóa ngoại và **phân trang 10 bản ghi/trang** (`LIMIT $start, $limit`). |
| **12** | **Truy vấn quan hệ** | `NhiemVu12_TruyVanDuLieu/` | Kết nối CSDL quan hệ `classes` & `students`, duyệt recordset theo cả 3 phương thức (`fetch_row`, `fetch_array`, `fetch_assoc`), hiển thị sinh viên theo lớp. |
| **13** | **Web bán Laptop (End user)** | `NhiemVu13_16_WebBanLaptop/` | Trang chủ hiển thị 2 sản phẩm mới nhất mỗi hãng, danh mục phân loại, tìm kiếm nâng cao theo hãng, trang chi tiết sản phẩm chuẩn E-Commerce. |
| **14** | **Web bán Laptop (Admin)** | `NhiemVu13_16_WebBanLaptop/admin/` | Quản trị viên quản lý danh sách Users (List, Add, Edit, Detail, Delete) và quản lý kho sản phẩm laptop. |
| **15** | **Chức năng Giỏ hàng** | `NhiemVu13_16_WebBanLaptop/` | Giỏ hàng Shopping Cart lưu trong Session: Thêm sản phẩm, tăng giảm số lượng, xóa từng món, xóa toàn bộ giỏ, tính tổng tiền thanh toán. |
| **16** | **Tích hợp Rich Text Box** | `NhiemVu13_16_WebBanLaptop/admin/` | Tích hợp trình soạn thảo WYSIWYG / CKEditor trực quan cho trường mô tả chi tiết sản phẩm laptop khi thêm mới và cập nhật. |

---

## 2. HƯỚNG DẪN CÀI ĐẶT & CHẠY TRÊN XAMPP

### Bước 1: Sao chép thư mục vào htdocs
Copy thư mục `Bai 4` vào thư mục `htdocs` của XAMPP:
```
C:\xampp\htdocs\CNWAT\Bai 4\
```
Hoặc tạo Virtual Host trỏ trực tiếp vào thư mục hiện tại:
`c:\Users\datpu\Desktop\Code\CNWAT\Bai 4\`

### Bước 2: Khởi động Apache & MySQL
Mở **XAMPP Control Panel**, nhấn nút **Start** tại 2 dịch vụ:
- **Apache** (Port 80 / 443)
- **MySQL** (Port 3306)

### Bước 3: Import các cơ sở dữ liệu MySQL
Mở trình duyệt truy cập `http://localhost/phpmyadmin`:
1. **Nhiệm vụ 11:** Tạo database `quanlyhocsinh` và import file:
   `Bai 4/NhiemVu11_CSDL_QuanLyHocSinh/quanlyhocsinh.sql`
2. **Nhiệm vụ 12:** Tạo database `school_db` và import file:
   `Bai 4/NhiemVu12_TruyVanDuLieu/database.sql`
3. **Nhiệm vụ 13-16:** Tạo database `laptop_shop` và import file:
   `Bai 4/NhiemVu13_16_WebBanLaptop/laptop_shop.sql`

### Bước 4: Truy cập và kiểm thử các bài tập
Mở trình duyệt và truy cập các đường dẫn:
- Cổng tổng quan Bài 4: `http://localhost/CNWAT/Bai 4/index.html` hoặc `index.php`
- Nhiệm vụ 1: `http://localhost/CNWAT/Bai 4/NhiemVu01_Template/index.php`
- Nhiệm vụ 2: `http://localhost/CNWAT/Bai 4/NhiemVu02_SuDungTemplate/register.php`
- Nhiệm vụ 3: `http://localhost/CNWAT/Bai 4/NhiemVu03_LayVaGuiDuLieu/index.php`
- Nhiệm vụ 4: `http://localhost/CNWAT/Bai 4/NhiemVu04_GetForm/index.php`
- Nhiệm vụ 5: `http://localhost/CNWAT/Bai 4/NhiemVu05_Session/index.php`
- Nhiệm vụ 6: `http://localhost/CNWAT/Bai 4/NhiemVu06_Cookie/index.php`
- Nhiệm vụ 7: `http://localhost/CNWAT/Bai 4/NhiemVu07_Function/index.php`
- Nhiệm vụ 8: `http://localhost/CNWAT/Bai 4/NhiemVu08_DocGhiFile/index.php`
- Nhiệm vụ 9: `http://localhost/CNWAT/Bai 4/NhiemVu09_QuanLyFile_QLSV/index.php`
- Nhiệm vụ 10: `http://localhost/CNWAT/Bai 4/NhiemVu10_DaNgonNgu/index.php`
- Nhiệm vụ 11: `http://localhost/CNWAT/Bai 4/NhiemVu11_CSDL_QuanLyHocSinh/lop_list.php`
- Nhiệm vụ 12: `http://localhost/CNWAT/Bai 4/NhiemVu12_TruyVanDuLieu/ListClass.php`
- Nhiệm vụ 13-16: `http://localhost/CNWAT/Bai 4/NhiemVu13_16_WebBanLaptop/index.php`
  - Admin Panel Laptop: `http://localhost/CNWAT/Bai 4/NhiemVu13_16_WebBanLaptop/admin/userList.php`

---

## 3. CÁC NGUYÊN TẮC BẢO MẬT & AN TOÀN WEB ĐÃ ÁP DỤNG

1. **Chống tấn công XSS (Cross-Site Scripting):**
   Mọi dữ liệu từ người dùng gửi lên (`$_GET`, `$_POST`, `$_COOKIE`) khi hiển thị ra giao diện HTML đều được bọc qua hàm `htmlspecialchars()`.
2. **Chống tấn công SQL Injection:**
   Các tham số truy vấn đều được ép kiểu số (`intval()`, `floatval()`) hoặc làm sạch ký tự thoát qua `mysqli_real_escape_string()`.
3. **Kiểm soát phiên Session & Phân quyền Admin:**
   Khu vực quản trị trong Nhiệm vụ 5 và Nhiệm vụ 14 kiểm tra nghiêm ngặt `$_SESSION['Username']`, tự động chặn và cảnh báo nếu người dùng chưa đăng nhập hợp lệ.
4. **Kiểm soát tính toàn vẹn dữ liệu khóa ngoại:**
   Khi thêm hồ sơ học sinh, hệ thống tải danh sách các mã lớp hợp lệ từ bảng `LOP` vào dropdown `<select>`, ngăn ngừa lỗi ràng buộc khóa ngoại (Foreign Key Constraint Violation).
