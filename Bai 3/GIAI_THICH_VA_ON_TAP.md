# TÀI LIỆU HƯỚNG DẪN GIẢI THÍCH CODE & ÔN TẬP VẤN ĐÁP
**Học phần:** Công nghệ Web An toàn  
**Sinh viên:** Phạm Tiến Đạt  
**Số thứ tự:** 04  
**Mã sinh viên:** AT200311  
**Lớp:** AT20A  

---

## I. TỔNG QUAN HỆ THỐNG CÁC BÀI TẬP ĐÃ LÀM

| STT | File mã nguồn | Mục trong đề | Kiến thức trọng tâm |
| :--- | :--- | :--- | :--- |
| 1 | `index.html` | Tổng hợp | Dashboard điều hướng các bài tập, bố cục Grid chuẩn |
| 2 | `css/common.css` | Layout chung | CSS Grid chia 4 vùng (info, banner, menu, content, footer) |
| 3 | `2.1_viju.html` | Mục 7.1 | 14 ví dụ JavaScript: biến, if/else, switch, Date, String, Array, setTimeout, sự kiện DOM |
| 4 | `2.2_tracnghiem.html` | Mục 7.2 | Cơ chế Tabs bài thi, Radio button, chấm điểm JS |
| 5 | `2.3_lop.html` | Mục 7.3 | Validation form bảng LOP: kiểm tra rỗng, độ dài chuỗi, số nguyên dương |
| 6 | `2.4_hoso.html` | Mục 7.4 | Validation form HOSO, kiểm tra kiểu Float và tự động tính tổng điểm 3 môn |
| 7 | `2.5_dangky.html` | Mục 7.5 | Form nâng cao: chuẩn hóa tên (Regex), Masked Date, phím Enter chuyển ô, Regex Email |
| 8 | `2.6_danhsach.html` | Mục 7.6 | Danh sách nhân sự: hover xanh lá, tick vàng dòng, checkbox Select All |
| 9 | `2.7_thucdon.html` | Mục 7.7 | Thực đơn bên trái, hover sáng, click đổi màu xanh và hiển thị tiêu đề bên phải |
| 10 | `2.8_tab.html` | Mục 7.8 | Chuyển đổi các Tab ngang, tab chọn màu cyan (#00bcd4) |
| 11 | `2.9_cay.html` | Mục 7.9 | Cây thư mục (Tree view): nút +/- đóng mở nhánh, chọn thư mục |
| 12 | `2.10_maytinh.html` | Mục 7.10 | Máy tính bỏ túi: +, -, *, /, %, +/-, C, CE |
| 13 | `2.11_hoatcanh.html` | Mục 7.11 | Hoạt cảnh người que nhảy (Stickman Jump) tuần tự trái-phải và ngược lại |
| 14 | `2.12_sapxep_timkiem.html` | Mục 7.12 | Bảng sản phẩm: sắp xếp tăng/giảm có icon ▲/▼ và tìm kiếm highlight vàng |

---

## II. BỘ CÂU HỎI & TRẢ LỜI VẤN ĐÁP KHI THẦY CÔ KIỂM TRA

### Câu 1: Em hãy giải thích kỹ thuật CSS Grid dùng trong file `common.css`?
**Trả lời:**
- Em sử dụng thuộc tính `display: grid;` trên thẻ `.container`.
- Khai báo các khu vực hiển thị bằng `grid-template-areas`:
  ```css
  grid-template-areas: 
      "info banner"
      "menu content"
      "footer footer";
  ```
- Dùng `grid-template-columns: 240px 1fr;` để cố định cột trái (thông tin SV + menu) là 240px, phần còn lại co giãn tự động (`1fr`).
- Sau đó ở mỗi khối con (student-info, banner, sidebar, main-content, footer), em gán `grid-area: <tên_vùng>` tương ứng.

---

### Câu 2: Trong bài 7.5 (Đăng ký thành viên), làm thế nào để chuẩn hóa họ tên người dùng?
**Trả lời:**
- Khi người dùng rời khỏi ô nhập (`onblur`), em thực hiện:
  1. Dùng `.trim()` để loại bỏ khoảng trắng dư ở đầu và cuối chuỗi.
  2. Dùng biểu thức chính quy `.replace(/\s+/g, ' ')` để gộp nhiều dấu cách liền nhau thành một dấu cách duy nhất.
  3. Dùng `.split(" ")` tách thành mảng các từ, sau đó duyệt từng từ viết hoa chữ cái đầu: `word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()`.
  4. Nối lại chuỗi bằng `.join(" ")` và gán lại cho `this.value`.

---

### Câu 3: Làm thế nào để bấm phím Enter chuyển sang ô nhập tiếp theo mà không submit form?
**Trả lời:**
- Bắt sự kiện `onkeydown` trên các ô input.
- Kiểm tra mã phím `if (evt.keyCode === 13)` (13 là phím Enter).
- Dùng `evt.preventDefault()` để ngăn chặn hành vi submit mặc định của trình duyệt.
- Lấy danh sách các ô input bằng `document.querySelectorAll("input")` và gọi `.focus()` vào ô `inputs[index + 1]`.

---

### Câu 4: Trong bài 7.6 (Danh sách nhân sự), cơ chế hoạt động của checkbox Select All là gì?
**Trả lời:**
- **Khi click vào ô tổng (`selectAllCheckbox`):** Lắng nghe sự kiện `change`, duyệt qua tất cả checkbox dòng con bằng `forEach` và gán `cb.checked = this.checked`, đồng thời thêm class `.selected` để tô vàng dòng.
- **Khi click vào từng checkbox con:** Kiểm tra xem tất cả các checkbox con đã được tick hết hay chưa bằng phương thức `Array.from(checkboxes).every(cb => cb.checked)`. Nếu tất cả đều `true` thì ô tổng tự động được tích chọn, nếu có ít nhất 1 ô chưa tích thì ô tổng bỏ chọn.

---

### Câu 5: Trong bài 7.12, làm sao để tìm kiếm và bôi vàng (highlight) từ khóa trực tiếp?
**Trả lời:**
- Bắt sự kiện `input` trên ô tìm kiếm `#searchInput`.
- Lấy từ khóa `keyword = this.value.trim().toLowerCase()`.
- Duyệt qua từng dòng trong bảng:
  - Nếu nội dung ô chứa từ khóa: dùng `new RegExp(keyword, 'gi')` và hàm `text.replace(regex, '<span class="highlight">$1</span>')` để bọc từ khóa lại bằng thẻ `<span>` có nền vàng.
  - Hiển thị dòng nếu tìm thấy (`row.style.display = ""`), hoặc ẩn dòng nếu không chứa từ khóa (`row.style.display = "none"`).

---

### Câu 6: Trong môn Công nghệ Web an toàn, việc dùng `innerHTML` có rủi ro bảo mật gì và cách khắc phục?
**Trả lời:**
- **Rủi ro:** Khi người dùng nhập chuỗi độc hại (ví dụ `<script>alert('hack')</script>` hoặc `<img src=x onerror=...>`), nếu đưa trực tiếp chuỗi này vào `innerHTML`, trình duyệt sẽ thực thi mã JavaScript độc hại của hacker, dẫn đến lỗ hổng **Cross-Site Scripting (XSS)**.
- **Khắc phục:**
  - Ưu tiên dùng `textContent` hoặc `innerText` khi chỉ hiển thị văn bản thô.
  - Kiểm tra, làm sạch dữ liệu đầu vào (Input Sanitization/Validation) trước khi xử lý.
