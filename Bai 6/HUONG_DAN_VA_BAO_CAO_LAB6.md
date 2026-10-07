# BÁO CÁO VÀ HƯỚNG DẪN THỰC HÀNH LAB 6: CƠ CHẾ AN TOÀN VÀ KỸ THUẬT NÂNG CAO (PHIÊN BẢN 1.3)
**HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN**  
**Học phần:** Công Nghệ Web An Toàn  
**Sinh viên thực hiện:** Phạm Tiến Đạt  
**Mã số sinh viên:** AT200311  
**Lớp:** AT20A  
**Năm học:** 2025 - 2026  

---

## 1. TỔNG QUAN HỆ THỐNG THỰC HÀNH BÀI 6

Bài thực hành số 6 tập trung vào **Cơ Chế An Toàn Và Kỹ Thuật Nâng Cao** (Phiên bản: 1.3) bao gồm 2 nhiệm vụ trọng tâm:

| Nhiệm vụ | Thư mục thực thi | Mô tả chức năng & Kiến trúc kỹ thuật |
|:---|:---|:---|
| **6.1: Kiện toàn & Bổ sung Nâng cao, An toàn cho Website** | `Bai 6/NhiemVu1_WebBanLaptop_MVC_Security/` | Kiện toàn website bán laptop từ Bài tập 4 theo kiến trúc **MVC**, tích hợp **Xác thực**, **Phân quyền RBAC**, **Xử lý hợp thức**, **Viết lại URL & Router**, **AJAX (jQuery) & Bootstrap 5**, **Tích hợp Rich Text Editor (Quill.js) & Datetime Picker (Flatpickr)**, phòng chống các tấn công phổ biến (**SQL Injection, XSS, CSRF, Session Fixation/Hijacking, Brute Force**). |
| **6.2: Xây dựng Ứng dụng Quản lý Danh bạ (Contacts) với Laravel** | `Bai 6/NhiemVu2_Laravel_Contacts/` | Xây dựng ứng dụng quản lý danh bạ chuẩn **Laravel Framework** (Migration, Models, Controller, Requests/Validation, Blade Templates `@csrf`, `@method`). Đầy đủ nghiệp vụ **CRUD**, lọc nhóm (Gia đình, Bạn bè, Công việc, Khách hàng), tìm kiếm theo thời gian thực, upload ảnh đại diện an toàn và **xuất danh bạ ra CSV**. Hỗ trợ cả `php artisan serve` lẫn chế độ Standalone Runner trên Apache XAMPP. |

---

## 2. CHI TIẾT TRIỂN KHAI NHIỆM VỤ 6.1 (WEBSITE LAPTOP MVC & BẢO MẬT)

### 2.1. Cấu trúc Mô hình MVC (Model - View - Controller)
- **Front Controller (`index.php`)**: Cổng tiếp nhận đơn nhất, tự động thiết lập HTTP Security Headers, kiểm soát Session an toàn và chuyển tiếp yêu cầu đến Router.
- **Core Engine (`core/`)**:
  - `Database.php`: Quản lý kết nối PDO đa driver (Ưu tiên kết nối MySQL `laptop_mvc_shop`, tự động fallback sang SQLite nếu MySQL chưa bật). 100% truy vấn dùng Prepared Statements.
  - `Security.php`: Đóng gói các cơ chế an toàn: CSRF Token sinh động, XSS HTML Escaping, Bcrypt Password Hashing, Rate Limiting chống Brute Force, chống Session Fixation và kiểm duyệt tệp tin tải lên.
  - `Router.php`: Điều phối URL sạch (Clean URL) và Query String (`index.php?r=controller/action`).
  - `Controller.php`: Lớp cơ sở cung cấp `render()`, `json()`, `redirect()`, `requireAuth()`, `requireAdmin()`.
  - `Model.php`: Lớp cơ sở tương tác CSDL với Prepared Statements.
- **Controllers (`controllers/`)**:
  - `HomeController.php`: Trang chủ hiển thị 2 sản phẩm mới nhất mỗi hãng theo đúng yêu cầu Bài 4 & Bài 6.
  - `ProductController.php`: Danh mục laptop, lọc đa tiêu chí, phân trang, chi tiết sản phẩm, AJAX Live Search dropdown.
  - `CartController.php`: Giỏ hàng Shopping Cart lưu trong Session, AJAX thêm giỏ hàng, cập nhật số lượng, tạo đơn hàng.
  - `AuthController.php`: Đăng ký tài khoản (mã hóa mật khẩu Bcrypt), đăng nhập (chống Brute Force sau 5 lần thử sai), đăng xuất an toàn.
  - `AdminController.php`: Bảng điều khiển (Dashboard thống kê), CRUD sản phẩm (Quill Rich Text & Flatpickr Datetime Picker), quản lý người dùng & phân quyền RBAC (Admin/Customer), quản lý đơn hàng.
- **Views (`views/`)**:
  - `layouts/main.php`: Giao diện khách hàng hiện đại, responsive Bootstrap 5, thanh tìm kiếm AJAX gợi ý tức thì, giỏ hàng badge cập nhật real-time.
  - `layouts/admin.php`: Giao diện quản trị viên chuyên nghiệp với Sidebar điều hướng, bảo vệ nghiêm ngặt bằng quyền `admin`.
  - Các thư mục view con: `home/`, `product/`, `cart/`, `auth/`, `admin/`.

### 2.2. Các Cơ Chế An Toàn Đã Tích Hợp (Security Implementations)
1. **Phòng chống SQL Injection:**
   - Tuyệt đối không nối chuỗi trong câu lệnh SQL (`query("SELECT ... WHERE id = " . $id)`).
   - 100% truy vấn thực thi qua `PDO::prepare()` và ràng buộc tham số `execute([$param])`.
2. **Phòng chống Cross-Site Scripting (XSS):**
   - Mọi dữ liệu xuất ra màn hình đều được xử lý qua hàm `Security::escape()` (`htmlspecialchars(ENT_QUOTES | ENT_HTML5, 'UTF-8')`).
   - Cấu hình HTTP Header `Content-Security-Policy` (CSP) ngăn chặn mã độc JavaScript ngoại lai.
3. **Phòng chống Cross-Site Request Forgery (CSRF):**
   - Tự động sinh `csrf_token` ngẫu nhiên 32 bytes (`bin2hex(random_bytes(32))`) lưu trong Session.
   - Kiểm tra `validateCsrfToken()` trong tất cả các thao tác thay đổi trạng thái (POST, PUT, DELETE).
4. **Bảo vệ Phiên làm việc (Session Security):**
   - Bật cờ `session.cookie_httponly = 1` ngăn chặn JavaScript đọc trộm Cookie Session ID.
   - Bật `session.cookie_samesite = 'Lax'` chống rò rỉ cookie qua liên kết ngoài trang.
   - Chống **Session Hijacking**: Ràng buộc mã băm `User-Agent` của trình duyệt, hủy phiên nếu phát hiện sai lệch.
   - Chống **Session Fixation**: Tự động gọi `session_regenerate_id(true)` ngay khi người dùng đăng nhập thành công.
5. **Phòng chống tấn công Dò mật khẩu (Brute Force):**
   - Cơ chế **Rate Limiting**: Giới hạn tối đa 5 lần đăng nhập thất bại trong vòng 5 phút từ một địa chỉ IP. Tự động khóa tạm thời và cảnh báo người dùng.
6. **Mã hóa Mật khẩu Người dùng:**
   - Mật khẩu lưu trữ được băm bằng thuật toán **Bcrypt** (`PASSWORD_BCRYPT` với cost=10).
7. **Bảo mật Tải lên Tệp tin (File Upload Security):**
   - Kiểm tra chặt chẽ định dạng mở rộng cho phép: `.jpg`, `.jpeg`, `.png`, `.webp`.
   - Kiểm tra thực chất nội dung tệp bằng `finfo(FILEINFO_MIME_TYPE)`.
   - Đổi tên tệp ngẫu nhiên (`laptop_xxx.jpg`) ngăn chặn tấn công Path Traversal và ghi đè tệp tin máy chủ.
   - Tệp `.htaccess` trong thư mục `uploads/` khóa triệt để khả năng thực thi script `.php` (ngăn ngừa Remote Code Execution - RCE).

---

## 3. CHI TIẾT TRIỂN KHAI NHIỆM VỤ 6.2 (LARAVEL CONTACTS APP)

### 3.1. Cấu trúc Ứng dụng Chuẩn Laravel
- **Migration (`database/migrations/2026_01_01_000001_create_contacts_table.php`)**: Định nghĩa cấu trúc bảng `contacts` gồm `name`, `phone`, `email`, `address`, `category`, `birthdate`, `notes`, `avatar`, `created_at`, `updated_at`.
- **Model (`app/Models/Contact.php`)**: Quản lý thuộc tính và danh mục phân loại (`Gia đình`, `Bạn bè`, `Công việc`, `Khách hàng`, `Đối tác`, `Khác`).
- **Controller (`app/Http/Controllers/ContactController.php`)**: Đầy đủ các hành động CRUD: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`, `exportCsv`.
- **Blade Views (`resources/views/`)**:
  - `layouts/app.blade.php`: Khung bố cục Blade dùng chung.
  - `contacts/index.blade.php`: Danh bạ thẻ Contact Card, phân loại nhóm bằng Chips, tìm kiếm thời gian thực.
  - `contacts/create.blade.php`: Form thêm liên hệ có `@csrf` và Datetime Picker Flatpickr.
  - `contacts/edit.blade.php`: Form chỉnh sửa có `@csrf` và `@method('PUT')`.
  - `contacts/show.blade.php`: Xem chi tiết liên hệ, nút gọi điện thoại nhanh, gửi email.
- **Routes (`routes/web.php`)**: Đăng ký các tuyến đường chuẩn RESTful.
- **CLI (`artisan`) & Batch Script (`start_laravel.bat`)**: Cho phép khởi chạy nhanh qua lệnh `php artisan serve` hoặc kích đúp chuột vào `start_laravel.bat`.

---

## 4. HƯỚNG DẪN CÀI ĐẶT & CHẠY TRÊN XAMPP

### Cách 1: Chạy trực tiếp qua máy chủ Apache của XAMPP (Khuyến nghị)
1. Thư mục mã nguồn nằm trong đường dẫn:
   `c:\xampp\htdocs\CNWAT\Bai 6\`
2. Khởi động **Apache** & **MySQL** trong XAMPP Control Panel.
3. Import cơ sở dữ liệu qua `http://localhost/phpmyadmin`:
   - Tạo DB `laptop_mvc_shop` và import file `Bai 6/NhiemVu1_WebBanLaptop_MVC_Security/laptop_mvc_shop.sql`.
   - Tạo DB `contacts_laravel` và import file `Bai 6/NhiemVu2_Laravel_Contacts/contacts.sql`.
   *(Lưu ý: Ngay cả khi chưa bật MySQL, hệ thống đã tích hợp sẵn cơ chế Auto-Fallback sang SQLite có nạp sẵn toàn bộ dữ liệu mẫu, ứng dụng sẽ chạy ngay lập tức mà không phát sinh lỗi!)*
4. Mở trình duyệt và truy cập:
   - **Cổng tổng quan Bài 6:** `http://localhost/CNWAT/Bai 6/index.html`
   - **Nhiệm vụ 6.1 (Website Bán Laptop MVC):** `http://localhost/CNWAT/Bai 6/NhiemVu1_WebBanLaptop_MVC_Security/index.php`
   - **Nhiệm vụ 6.2 (Laravel Contacts):** `http://localhost/CNWAT/Bai 6/NhiemVu2_Laravel_Contacts/index.php`

### Cách 2: Chạy độc lập bằng PHP Built-in Server / Artisan
- Khởi động Nhiệm vụ 6.1:
  ```bash
  cd "Bai 6/NhiemVu1_WebBanLaptop_MVC_Security"
  php -S 127.0.0.1:8080
  ```
  Truy cập: `http://localhost:8080`

- Khởi động Nhiệm vụ 6.2:
  ```bash
  cd "Bai 6/NhiemVu2_Laravel_Contacts"
  php artisan serve
  ```
  Hoặc kích đúp vào tệp tin `start_laravel.bat`. Truy cập: `http://localhost:8000`

---

## 5. TÀI KHOẢN KIỂM THỬ HỆ THỐNG

| Phân hệ | Tên đăng nhập (Username) | Mật khẩu (Password) | Vai trò (Role) | Chức năng được phép |
|:---|:---|:---|:---|:---|
| **Quản trị viên** | `admin` | `123456` | `admin` | Toàn quyền Dashboard, CRUD Laptop, Rich Text Editor, Phân quyền User, Quản lý Đơn hàng |
| **Khách hàng** | `customer` | `123456` | `customer` | Xem sản phẩm, tìm kiếm, lọc theo hãng, giỏ hàng, đặt hàng thanh toán |

---

*Học viện Kỹ thuật Mật mã - Khoa An Toàn Thông Tin - Năm học 2025 - 2026*  
*Sinh viên: Phạm Tiến Đạt - AT200311*
