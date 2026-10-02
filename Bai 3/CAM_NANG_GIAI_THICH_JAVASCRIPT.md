# CẨM NANG GIẢI THÍCH CHI TIẾT TỪNG ĐOẠN CODE JAVASCRIPT CHO NGƯỜI MỚI BẮT ĐẦU
**Học phần:** Công nghệ Web An toàn  
**Sinh viên thực hiện:** Phạm Tiến Đạt  
**Số thứ tự:** 04 | **MSSV:** AT200311 | **Lớp:** AT20A  

Tài liệu này được biên soạn tỉ mỉ theo phong cách "cầm tay chỉ việc", bóc tách chi tiết từng dòng lệnh JavaScript trong từng file bài tập HTML. Dù bạn là người mới học lập trình web, bạn cũng sẽ hiểu rõ bản chất: **lệnh này làm gì**, **tại sao lại viết như vậy**, và **cần chú ý điều gì khi bảo vệ/vấn đáp bài tập**.

---

# MỤC LỤC
1. [File 1: `2.1_viju.html` - 14 Ví dụ mẫu nền tảng JavaScript](#1-file-21_vijuhtml---14-ví-dụ-mẫu-nền-tảng-javascript)
2. [File 2: `2.2_tracnghiem.html` - Cơ chế chuyển Tab & Chấm điểm trắc nghiệm](#2-file-22_tracnghiemhtml---cơ-chế-chuyển-tab--chấm-điểm-trắc-nghiệm)
3. [File 3: `2.3_lop.html` - Form Nhập liệu & Kiểm tra dữ liệu (Validation)](#3-file-23_lophtml---form-nhập-liệu--kiểm-tra-dữ-liệu-validation)
4. [File 4: `2.4_hoso.html` - Form Hồ sơ & Tính tổng điểm số thực](#4-file-24_hosohtml---form-hồ-sơ--tính-tổng-điểm-số-thực)
5. [File 5: `2.5_dangky.html` - Form Đăng ký nâng cao (Regex, Masked, Enter Key)](#5-file-25_dangkyhtml---form-đăng-ký-nâng-cao-regex-masked-enter-key)
6. [File 6: `2.6_danhsach.html` - Bảng nhân sự, Checkbox Select All & Highlight](#6-file-26_danhsachhtml---bảng-nhân-sự-checkbox-select-all--highlight)
7. [File 7: `2.7_thucdon.html` - Thực đơn chuyển đổi tiêu đề hiển thị](#7-file-27_thucdonhtml---thực-đơn-chuyển-đổi-tiêu-đề-hiển-thị)
8. [File 8: `2.8_tab.html` - Hệ thống Tab nội dung ngang](#8-file-28_tabhtml---hệ-thống-tab-nội-dung-ngang)
9. [File 9: `2.9_cay.html` - Cây thư mục (Tree View) đóng mở đa cấp](#9-file-29_cayhtml---cây-thư-mục-tree-view-đóng-mở-đa-cấp)
10. [File 10: `2.10_maytinh.html` - Máy tính điện tử bỏ túi](#10-file-210_maytinhhtml---máy-tính-điện-tử-bỏ-túi)
11. [File 11: `2.11_hoatcanh.html` - Hoạt cảnh người que nhảy (Jump & Stop)](#11-file-211_hoatcanhhtml---hoạt-cảnh-người-que-nhảy-jump--stop)
12. [File 12: `2.12_sapxep_timkiem.html` - Sắp xếp bảng & Live Search Highlight](#12-file-212_sapxep_timkiemhtml---sắp-xếp-bảng--live-search-highlight)

---

# 1. File: `2.1_viju.html` - 14 Ví dụ mẫu nền tảng JavaScript

File này gồm 14 ví dụ cơ bản giúp làm quen với cú pháp cốt lõi của JS.

### Câu 1: Khai báo biến và thay đổi giá trị
```javascript
(function runCau1() {
    var name = "Phạm Tiến Đạt";
    var html = "<b>" + name + "</b><br>";
    name = "AT200311 - Lớp AT20";
    html += name;
    document.getElementById("demo1").innerHTML = html;
})();
```
- **Bản chất:**
  - `(function runCau1() { ... })();`: Đây là kỹ thuật **IIFE** (Immediately Invoked Function Expression) - hàm tự động thực thi ngay khi đọc đến mà không cần gọi tên.
  - `var name = "Phạm Tiến Đạt";`: Khai báo một biến tên `name` mang kiểu chuỗi.
  - `name = "AT200311...";`: Gán đè giá trị mới cho biến `name`. JS là ngôn ngữ định kiểu động (dynamic typing), biến có thể thay đổi giá trị linh hoạt.
  - `document.getElementById("demo1").innerHTML = html;`: Tìm đến thẻ HTML có `id="demo1"` và thay thế nội dung HTML bên trong nó bằng chuỗi `html`.

---

### Câu 2: Lấy dữ liệu từ Textbox thông qua DOM Form
```javascript
function chayCau2() {
    var a = window.document.bai1.T1.value;
    if (!a) {
        alert("Bạn chưa nhập giá trị vào ô textbox!");
        return;
    }
    alert("Số bạn vừa nhập là: " + a);
}
```
- **Bản chất:**
  - `window.document.bai1.T1.value`: Đây là cách truy cập DOM cổ điển: từ đối tượng cửa sổ `window` -> tài liệu `document` -> form có `name="bai1"` -> ô input có `name="T1"` -> lấy thuộc tính `.value` (giá trị người dùng đã gõ).
  - `if (!a)`: Kiểm tra nếu `a` rỗng (chuỗi `""` tương đương giá trị falsy trong JS) thì hiện thông báo nhắc nhở bằng hàm `alert()`.
  - `return;`: Lệnh dừng thực thi hàm ngay lập tức, không chạy các lệnh phía sau.

---

### Câu 3: Ép kiểu dữ liệu và rẽ nhánh với `if...else`
```javascript
function chayCau3() {
    var val = window.document.bai3.T1.value;
    if (val.trim() === "") {
        alert("Vui lòng nhập một số!");
        return;
    }
    var a = val * 1;
    if ((a % 2) === 0) {
        alert(a + " là số chẵn");
    } else {
        alert(a + " là số lẻ");
    }
}
```
- **Bản chất:**
  - `.trim()`: Cắt bỏ khoảng trắng thừa ở 2 đầu chuỗi (ví dụ `"  5  "` biến thành `"5"`).
  - `val * 1`: Trong JS, dữ liệu lấy từ ô `input` **luôn luôn là kiểu String (chuỗi)**. Phép nhân `* 1` là một mẹo ép kiểu chuỗi thành kiểu số (`Number`). Bạn cũng có thể dùng `parseInt(val)` hoặc `Number(val)`.
  - `(a % 2) === 0`: Toán tử `%` là phép chia lấy phần dư. Nếu số chia cho 2 dư 0 thì là số chẵn, ngược lại là số lẻ.

---

### Câu 4: Đối tượng thời gian `Date`
```javascript
(function runCau4() {
    var d = new Date();
    var time = d.getHours();
    var msg = "";
    if (time < 10) {
        msg = "<b>Good morning</b> (Bây giờ là " + time + "h sáng)";
    } else if (time >= 10 && time < 16) {
        msg = "<b>Good day / afternoon</b> (Bây giờ là " + time + "h)";
    } else {
        msg = "<b>Hello World / Good evening!</b> (Bây giờ là " + time + "h tối)";
    }
    document.getElementById("demo4").innerHTML = msg;
})();
```
- **Bản chất:**
  - `new Date()`: Khởi tạo một đối tượng thời gian thực lấy từ đồng hồ hệ thống của máy tính khách (Client).
  - `d.getHours()`: Phương thức trả về giờ hiện tại (từ 0 đến 23).
  - Cấu trúc `if ... else if ... else`: Rẽ nhánh nhiều điều kiện để in ra lời chào tương ứng theo buổi trong ngày.

---

### Câu 5: Cấu trúc rẽ nhánh `switch...case`
```javascript
(function runCau5() {
    var d = new Date();
    var theDay = d.getDay();
    var textDay = "";
    switch (theDay) {
        case 5: textDay = "Friday (Thứ Sáu)"; break;
        case 6: textDay = "Saturday (Thứ Bảy)"; break;
        case 0: textDay = "Sunday (Chủ Nhật)"; break;
        case 1: textDay = "Monday - Chúc đầu tuần vui vẻ!"; break;
        default: textDay = "Hôm nay là ngày trong tuần (Thứ " + (theDay + 1) + ") - Chúc bạn làm việc hiệu quả!";
    }
    document.getElementById("demo5").innerHTML = "Thứ hiện tại: <strong>" + textDay + "</strong>";
})();
```
- **Bản chất:**
  - `d.getDay()`: Trả về chỉ số ngày trong tuần, quy ước: **0 là Chủ nhật, 1 là Thứ Hai, 2 là Thứ Ba,..., 6 là Thứ Bảy**.
  - `switch (theDay)`: So sánh giá trị `theDay` với từng trường hợp `case`.
  - `break;`: **Rất quan trọng!** Bắt buộc phải có lệnh `break` để thoát khỏi khối `switch`. Nếu quên `break`, chương trình sẽ bị hiện tượng "fall-through" - tức là tự động chạy tiếp các lệnh của các case bên dưới.
  - `default`: Chạy khi không khớp với bất kỳ case nào ở trên.

---

### Câu 6: Hộp thoại xác nhận `confirm()`
```javascript
function disp_confirm() {
    var r = confirm("Nhấn một nút (OK hoặc Cancel):");
    var out = document.getElementById("demo6");
    if (r === true) {
        out.innerHTML = "<span style='color:green; font-weight:bold;'>Bạn vừa chọn: OK!</span>";
    } else {
        out.innerHTML = "<span style='color:red; font-weight:bold;'>Bạn vừa chọn: Cancel!</span>";
    }
}
```
- **Bản chất:**
  - `confirm("...")`: Bật lên một cửa sổ popup tương tác của trình duyệt gồm 2 nút **OK** và **Cancel**.
  - Hàm này trả về giá trị kiểu boolean: nếu người dùng bấm OK thì `r = true`, nếu bấm Cancel thì `r = false`.

---

### Câu 7: Hộp thoại nhập liệu `prompt()`
```javascript
function disp_prompt() {
    var name = prompt("VUI LÒNG NHẬP TÊN CỦA BẠN:", "Phạm Tiến Đạt");
    var out = document.getElementById("demo7");
    if (name != null && name !== "") {
        out.innerHTML = "XIN CHÀO <strong>" + name + "</strong>! Chúc bạn một ngày tốt lành.";
    }
}
```
- **Bản chất:**
  - `prompt(thông_báo, giá_trị_mặc_định)`: Bật popup có một ô input cho phép người dùng gõ văn bản vào.
  - Nếu người dùng bấm **Cancel**, hàm trả về `null`. Nếu người dùng bấm **OK**, hàm trả về chuỗi họ đã nhập.
  - Điều kiện `name != null && name !== ""` giúp đảm bảo người dùng có nhập chữ và không bấm hủy.

---

### Câu 8: Các phương thức xử lý chuỗi (String Methods)
```javascript
(function runCau8() {
    var str = "Hello world!";
    var res = "";
    res += "Chuỗi gốc: '" + str + "'<br>";
    res += "Vị trí của 'Hello': " + str.indexOf("Hello") + "<br>";
    res += "Vị trí của 'World': " + str.indexOf("World") + " (-1 vì phân biệt hoa thường)<br>";
    res += "Vị trí của 'world': " + str.indexOf("world") + "<br>";
    res += "In hoa (toUpperCase): " + str.toUpperCase() + "<br>";
    res += "Độ dài chuỗi (length): " + str.length + "<br>";
    res += "Thay thế (replace 'w' thành 'W'): " + str.replace("w", "W");
    document.getElementById("demo8").innerHTML = res;
})();
```
- **Bản chất:**
  - `.indexOf("...")`: Tìm vị trí xuất hiện đầu tiên của chuỗi con (tính từ chỉ số 0). Nếu không tìm thấy, hàm trả về **`-1`**. Lưu ý: hàm có phân biệt chữ hoa và chữ thường!
  - `.toUpperCase()`: Trả về một chuỗi mới được viết hoa toàn bộ ký tự.
  - `.length`: Thuộc tính (không có dấu ngoặc tròn) trả về độ dài số lượng ký tự của chuỗi.
  - `.replace("w", "W")`: Tìm ký tự "w" đầu tiên và thay bằng "W".

---

### Câu 9: Mảng `Array` và vòng lặp `for...in`
```javascript
(function runCau9() {
    var mycars = new Array();
    mycars[0] = "Saab";
    mycars[1] = "Volvo";
    mycars[2] = "BMW";
    mycars[3] = "Mercedes-Benz";
    var res = "Danh sách xe hơi trong mảng:<br>";
    for (var x in mycars) {
        res += "- Xe " + x + ": <strong>" + mycars[x] + "</strong><br>";
    }
    document.getElementById("demo9").innerHTML = res;
})();
```
- **Bản chất:**
  - `new Array()`: Khởi tạo đối tượng mảng rỗng (hoặc có thể viết rút gọn là `var mycars = []`).
  - `mycars[0] = "Saab"`: Gán phần tử vào chỉ mục (index) số 0.
  - `for (var x in mycars)`: Vòng lặp `for...in` dùng để duyệt qua tất cả các **chỉ mục (key/index)** của mảng hoặc đối tượng. Biến `x` lần lượt nhận các giá trị `"0"`, `"1"`, `"2"`, `"3"`. Muốn lấy giá trị bên trong thì gọi `mycars[x]`.

---

### Câu 10 & 11: Bộ định thời gian `setTimeout()`
```javascript
// Câu 10
function timedMsg() {
    var st = document.getElementById("demo10-status");
    st.innerText = "Đang đếm 5 giây... xin chờ";
    setTimeout(function() {
        alert("Đã đủ 5 giây!");
        st.innerText = "Đã thực thi xong 5 giây.";
    }, 5000);
}

// Câu 11
function timedText() {
    var txtBox = document.getElementById("txt");
    txtBox.value = "Đang chạy đếm ngược...";
    setTimeout(function() {
        window.document.lam.txt.value = "2 seconds passed!";
    }, 2000);
    setTimeout(function() {
        document.getElementById("txt").value = "4 seconds passed!";
    }, 4000);
    setTimeout(function() {
        document.getElementById("txt").value = "6 seconds passed (Hoàn thành)!";
    }, 6000);
}
```
- **Bản chất:**
  - `setTimeout(hàm_xử_lý, thời_gian_ms)`: Hàm lập lịch hẹn giờ. Đơn vị tính bằng **mili-giây (1000ms = 1 giây)**. Sau khi hết số mili-giây quy định, trình duyệt sẽ gọi thực thi hàm bên trong.
  - Trong câu 11, ba lệnh `setTimeout` được kích hoạt cùng lúc khi bấm nút, nhưng với thời gian trễ khác nhau: 2000ms (2s), 4000ms (4s) và 6000ms (6s), tạo nên chuỗi hiển thị chữ nối tiếp nhau rất đẹp mắt.

---

### Câu 12: Đồng hồ điện tử thời gian thực (Đệ quy với `setTimeout`)
```javascript
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    var clk = document.getElementById('clock');
    if (clk) {
        clk.innerHTML = h + ":" + m + ":" + s;
    }
    setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) { i = "0" + i; }
    return i;
}
window.addEventListener("load", startTime);
```
- **Bản chất:**
  - `today.getMinutes()` và `today.getSeconds()`: Lấy phút và giây hiện tại.
  - Hàm `checkTime(i)`: Nếu số phút/giây nhỏ hơn 10 (ví dụ số 5), nó sẽ ghép số `"0"` vào trước để thành `"05"`, giúp đồng hồ luôn chuẩn định dạng `hh:mm:ss`.
  - `setTimeout(startTime, 500);`: **Kỹ thuật đệ quy có trễ**. Cứ sau 500 mili-giây (nửa giây), hàm `startTime` lại tự gọi lại chính nó, làm mới màn hình hiển thị giờ liên tục theo thời gian thực.
  - `window.addEventListener("load", startTime)`: Lắng nghe khi nào trang web tải xong toàn bộ thì bắt đầu kích hoạt đồng hồ.

---

### Câu 13: Bắt sự kiện rê chuột đổi ảnh (`onmouseover` / `onmouseout`)
```javascript
function mouseOver() {
    document.getElementById("hoverImg").src = "https://via.placeholder.com/206x106/27ae60/ffffff?text=Image+B+(Re+chuot+ra)";
}
function mouseOut() {
    document.getElementById("hoverImg").src = "https://via.placeholder.com/206x106/3498db/ffffff?text=Image+A+(Dua+chuot+vao)";
}
```
- **Bản chất:**
  - `mouseOver()`: Được kích hoạt khi con trỏ chuột di chuyển vào bức ảnh (`onmouseover`). Lệnh gán lại thuộc tính `.src` của thẻ `<img>` sang URL của bức ảnh thứ hai.
  - `mouseOut()`: Được kích hoạt khi con trỏ chuột rời khỏi bức ảnh (`onmouseout`). Lệnh trả lại `.src` ban đầu.

---

### Câu 14: Mảng tra cứu (Associative Array) kết hợp thẻ `<select>`
```javascript
var phone = new Array();
phone["dat"] = "0988.123.456 (SV: Phạm Tiến Đạt)";
phone["lam"] = "090540468";
phone["duc"] = "0905274747";
...
function disphone(thephone, entry) {
    var num = thephone[entry] || "";
    window.document.myform.numbox.value = num;
}
```
- **Bản chất:**
  - `phone["dat"] = "..."`: Mảng kết hợp (Associative Array / Map trong JS) cho phép dùng chuỗi ký tự làm khóa (key) thay vì chỉ số số nguyên (0, 1, 2).
  - Khi người dùng chọn một mục trong thẻ `<select>`, sự kiện `onchange` gửi giá trị `this.options[this.selectedIndex].value` (chính là chuỗi `"dat"`, `"lam"`,...) vào tham số `entry`.
  - `thephone[entry]`: Truy xuất số điện thoại tương ứng với khóa được truyền vào rồi gán vào thuộc tính `.value` của ô input `numbox`.

---

# 2. File: `2.2_tracnghiem.html` - Cơ chế chuyển Tab & Chấm điểm trắc nghiệm

```javascript
function openTest(testName, btn) {
    // 1. Ẩn tất cả các khối bài thi (.test-content)
    var testContents = document.getElementsByClassName("test-content");
    for (var i = 0; i < testContents.length; i++) {
        testContents[i].style.display = "none";
        testContents[i].classList.remove("active");
    }

    // 2. Xóa trạng thái active ở các nút tab
    var tabButtons = document.getElementsByClassName("tab-btn");
    for (var i = 0; i < tabButtons.length; i++) {
        tabButtons[i].classList.remove("active");
    }

    // 3. Kích hoạt hiển thị bài thi được chọn
    var selectedTest = document.getElementById(testName);
    if (selectedTest) {
        selectedTest.style.display = "block";
        selectedTest.classList.add("active");
    }

    // 4. Gán class active cho nút tab vừa bấm
    if (btn) {
        btn.classList.add("active");
    }
}
```
- **Bản chất thuật toán chuyển Tab (Tabs Switcher):**
  1. **Bước quét sạch (Reset):** Dùng `document.getElementsByClassName("test-content")` để lấy danh sách tất cả các bài thi, duyệt vòng lặp `for` gán `style.display = "none"` để ẩn toàn bộ. Đồng thời xóa gạch chân (`active`) ở các nút bấm.
  2. **Bước kích hoạt (Activate):** Lấy đúng bài thi có `id` trùng với `testName` (ví dụ `"test1"` hoặc `"test2"`) và đổi sang `style.display = "block"` để làm hiện ra. Nút vừa bấm được thêm class `active`.

```javascript
function submitTest2() {
    var math1 = document.querySelector('input[name="math1"]:checked');
    var port = document.querySelector('input[name="port"]:checked');
    var res = document.getElementById("resTest2");

    if (!math1 || !port) {
        alert("Vui lòng trả lời đầy đủ các câu hỏi của Test 2!");
        return;
    }

    var score = 0;
    if (math1.value === "2") score++;
    if (port.value === "443") score++;
    ...
}
```
- **Bản chất:**
  - `document.querySelector('input[name="math1"]:checked')`: Sử dụng bộ chọn CSS Selector để tìm thẻ radio nào có tên là `math1` đang **được tích chọn (`:checked`)**. Nếu người dùng chưa chọn đáp án nào, lệnh này sẽ trả về `null`.
  - `if (!math1 || !port)`: Nếu 1 trong 2 câu chưa được chọn thì cảnh báo và dừng hàm.
  - So sánh giá trị `.value` với đáp án chuẩn (`"2"` và `"443"`), nếu đúng thì tăng biến `score++`.

---

# 3. File: `2.3_lop.html` - Form Nhập liệu & Kiểm tra dữ liệu (Validation)

```javascript
function validateFormLop() {
    // 1. Lấy dữ liệu và loại bỏ khoảng trắng ở 2 đầu bằng hàm trim()
    var maLop = document.getElementById("malop").value.trim();
    var tenLop = document.getElementById("tenlop").value.trim();
    var khoaHoc = document.getElementById("khoahoc").value.trim();
    var gvcn = document.getElementById("gvcn").value.trim();

    var errorDiv = document.getElementById("error-msg");
    var successDiv = document.getElementById("success-msg");
    var errorMessage = "";

    errorDiv.style.display = "none";
    successDiv.style.display = "none";

    // 2. Kiểm tra ràng buộc MALOP (Char(6))
    if (maLop === "") {
        errorMessage = "Vui lòng nhập Mã Lớp.";
    } else if (maLop.length > 6) {
        errorMessage = "Mã Lớp không được quá 6 ký tự.";
    }
    // 3. Kiểm tra ràng buộc TENLOP (Char(50))
    else if (tenLop === "") {
        errorMessage = "Vui lòng nhập Tên Lớp.";
    } else if (tenLop.length > 50) {
        errorMessage = "Tên Lớp không được vượt quá 50 ký tự.";
    }
    // 4. Kiểm tra ràng buộc KHOAHOC (Integer, số nguyên dương)
    else if (khoaHoc === "") {
        errorMessage = "Vui lòng nhập Khóa Học.";
    } else if (isNaN(khoaHoc) || parseInt(khoaHoc, 10) <= 0 || !Number.isInteger(Number(khoaHoc))) {
        errorMessage = "Khóa Học phải là một số nguyên dương hợp lệ (Ví dụ: 20).";
    }
    // 5. Kiểm tra ràng buộc GVCN (Char(50))
    else if (gvcn === "") {
        errorMessage = "Vui lòng nhập tên Giáo Viên Chủ Nhiệm.";
    } else if (gvcn.length > 50) {
        errorMessage = "Tên GVCN không được vượt quá 50 ký tự.";
    }

    // 6. Xử lý kết quả kiểm tra
    if (errorMessage !== "") {
        errorDiv.style.display = "block";
        errorDiv.innerHTML = "⚠️ " + errorMessage;
        return false; // Chặn gửi form
    } else {
        successDiv.style.display = "block";
        successDiv.innerHTML = " Dữ liệu hợp lệ! Đã lưu thông tin lớp...";
        return false;
    }
}
```
- **Giải thích chi tiết từng bước Validation:**
  - `document.getElementById("...").value.trim()`: Lấy nội dung người dùng nhập và làm sạch khoảng trắng thừa ở hai đầu bằng `.trim()`. Tránh việc người dùng chỉ gõ toàn dấu cách `"   "` để qua mặt kiểm tra rỗng.
  - `maLop.length > 6`: Thuộc tính `.length` kiểm tra độ dài chuỗi để đảm bảo đúng định dạng cơ sở dữ liệu `Char(6)`.
  - `isNaN(khoaHoc)`: Hàm `isNaN()` (viết tắt của **is Not-a-Number**) kiểm tra xem giá trị có phải là số hay không. Nếu người dùng nhập chữ `"abc"` thì `isNaN("abc")` trả về `true`.
  - `parseInt(khoaHoc, 10) <= 0`: Chuyển chuỗi thành số nguyên hệ cơ số 10 và kiểm tra phải là số dương (> 0).
  - `return false;`: Trong form HTML có sự kiện `onsubmit="return validateFormLop();"`. Nếu hàm trả về `false`, trình duyệt sẽ **hủy việc gửi dữ liệu đi**, giúp trang web không bị tải lại (reload) và giữ nguyên thông báo lỗi cho người dùng sửa.

---

# 4. File: `2.4_hoso.html` - Form Hồ sơ & Tính tổng điểm số thực

```javascript
function validateFormHoSo() {
    ...
    // 1. Ép kiểu chuỗi sang float
    var fToan = parseFloat(diemtoan);
    var fLy = parseFloat(diemly);
    var fHoa = parseFloat(diemhoa);

    // 2. Tính tổng điểm
    var tongDiem = fToan + fLy + fHoa;

    // 3. Làm tròn số 2 chữ số thập phân
    tongDiem = Math.round(tongDiem * 100) / 100;
    ...
}
```
- **Bản chất:**
  - `parseFloat(...)`: Chuyển chuỗi thành số thực (ví dụ `"8.5"` thành `8.5`). Điểm thi có phần thập phân nên phải dùng `parseFloat` chứ không dùng `parseInt`.
  - `var tongDiem = fToan + fLy + fHoa;`: Thực hiện phép cộng toán học giữa 3 số thực.
  - `Math.round(tongDiem * 100) / 100`: **Mẹo làm tròn trong JavaScript**. Do biểu diễn số thực dấu phẩy động (floating point IEEE 754) trong máy tính, phép cộng như `0.1 + 0.2` sẽ ra `0.30000000000000004`. Bằng cách nhân 100 -> làm tròn nguyên bằng `Math.round()` -> rồi chia lại cho 100, ta sẽ thu được kết quả chính xác tuyệt đối với 2 chữ số thập phân (ví dụ `25.75`).

---

# 5. File: `2.5_dangky.html` - Form Đăng ký nâng cao (Regex, Masked, Enter Key)

Đây là file có độ phức tạp cao nhất trong học phần, kết hợp nhiều sự kiện DOM khác nhau:

### 5.1. Focus và gán sự kiện khi tải trang
```javascript
window.onload = function() {
    var hoTenInput = document.getElementById("hoTen");
    if (hoTenInput) {
        hoTenInput.focus();
    }
    ganSuKienEnter();
};
```
- `hoTenInput.focus()`: Tự động đưa con trỏ soạn thảo chuột vào ô nhập họ tên ngay khi vừa mở trang web, người dùng không cần phải click chuột.

---

### 5.2. Chuẩn hóa chuỗi Họ và Tên khi rời chuột (`onblur`)
```javascript
var txtHoTen = document.getElementById("hoTen");
txtHoTen.onblur = function() {
    var val = this.value.trim();
    if (val !== "") {
        // Thay nhiều khoảng trắng liền kề bằng 1 khoảng trắng duy nhất
        val = val.replace(/\s+/g, ' ');
        var arr = val.split(" ");
        for (var i = 0; i < arr.length; i++) {
            arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1).toLowerCase();
        }
        this.value = arr.join(" ");
    }
};
```
- **Giải thích từng bước:**
  - `onblur`: Sự kiện xảy ra khi ô input mất tiêu điểm (người dùng click ra ngoài hoặc tab sang ô khác).
  - `val.replace(/\s+/g, ' ')`: Dùng biểu thức chính quy (Regex). `\s+` đại diện cho một hoặc nhiều khoảng trắng liên tiếp, cờ `g` (global) tìm trên toàn bộ chuỗi. Lệnh này chuyển `"phạm    tiến   đạt"` thành `"phạm tiến đạt"`.
  - `val.split(" ")`: Cắt chuỗi thành mảng các từ đơn lẻ: `["phạm", "tiến", "đạt"]`.
  - `arr[i].charAt(0).toUpperCase()`: Lấy ký tự đầu tiên tại chỉ số 0 và viết hoa lên.
  - `arr[i].slice(1).toLowerCase()`: Cắt phần đuôi từ vị trí thứ 1 trở đi và chuyển thành chữ thường.
  - `arr.join(" ")`: Ghép các từ trong mảng lại với nhau bằng dấu cách, cho kết quả hoàn hảo: `"Phạm Tiến Đạt"`.

---

### 5.3. Giả lập Placeholder Ngày sinh & Masking tự thêm dấu `/`
```javascript
var txtNgaySinh = document.getElementById("ngaySinh");

txtNgaySinh.onfocus = function() {
    if (this.value === "nn/tt/nnnn") {
        this.value = "";
        this.className = "field-input bat-buoc black-text";
    }
};

txtNgaySinh.onblur = function() {
    if (this.value.trim() === "") {
        this.value = "nn/tt/nnnn";
        this.className = "field-input bat-buoc gray-text";
    }
};

txtNgaySinh.onkeyup = function(e) {
    var evt = e || window.event;
    if (evt.keyCode !== 8) { // 8 là mã phím Backspace
        var val = this.value;
        if (val.length === 2 || val.length === 5) {
            this.value = val + "/";
        }
    }
};
```
- **Bản chất:**
  - Sự kiện `onfocus` & `onblur`: Giả lập placeholder theo chuẩn HTML cũ như đề bài yêu cầu. Khi click vào ô thì xóa chữ gợi ý `"nn/tt/nnnn"` và chuyển màu chữ sang đen; nếu rời khỏi ô mà chưa nhập gì thì trả lại chữ xám.
  - Sự kiện `onkeyup` (xảy ra khi người dùng nhả phím): Khi gõ đủ 2 ký tự (ví dụ gõ `"04"` ngày), code tự nối thêm dấu `/` để thành `"04/"`; gõ tiếp 2 ký tự tháng (`"04/08"` độ dài là 5), code tự nối thêm dấu `/` thành `"04/08/"`.
  - `evt.keyCode !== 8`: Bắt buộc phải bỏ qua phím Backspace (xóa lùi), nếu không người dùng sẽ không thể bấm xóa ký tự được.

---

### 5.4. Kiểm tra định dạng Email bằng biểu thức chính quy (Regex)
```javascript
var txtEmail = document.getElementById("email");
txtEmail.onblur = function() {
    var val = this.value.trim();
    var span = document.getElementById("err-email");
    var regex = /^[\w\.]+@[\w\.]+\.\w+$/;
    if (val !== "" && !regex.test(val)) {
        span.innerHTML = "Email không đúng định dạng!";
    } else {
        span.innerHTML = "";
    }
};
```
- **Bản chất Regex `/^[\w\.]+@[\w\.]+\.\w+$/`:**
  - `^`: Bắt đầu chuỗi.
  - `[\w\.]+`: Chứa các chữ cái, chữ số, dấu gạch dưới hoặc dấu chấm (tên email).
  - `@`: Bắt buộc phải có ký tự `@`.
  - `[\w\.]+`: Tên miền cấp 2 (ví dụ `gmail`, `actvn`).
  - `\.`: Dấu chấm ngăn cách tên miền.
  - `\w+$`: Phần đuôi mở rộng (`com`, `edu`, `vn`) và kết thúc chuỗi (`$`).
  - `!regex.test(val)`: Hàm `.test()` kiểm tra xem chuỗi có thỏa mãn cấu trúc hay không. Nếu không khớp thì báo lỗi ra thẻ `span`.

---

### 5.5. Phím Enter chuyển ô tiếp theo (Keyboard Navigation)
```javascript
function ganSuKienEnter() {
    var inputs = document.querySelectorAll("#frmDangKy input[type='text'], #frmDangKy input[type='password']");
    inputs.forEach(function(input, index) {
        input.onkeydown = function(e) {
            var evt = e || window.event;
            if (evt.keyCode === 13) { // 13 là phím Enter
                if (evt.preventDefault) evt.preventDefault();
                evt.returnValue = false;
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus(); // Chuyển focus sang ô sau
                }
            }
        };
    });
}
```
- **Bản chất:**
  - Mặc định trên trình duyệt, khi đang ở trong ô input mà nhấn Enter, form sẽ tự động gửi đi (`submit`).
  - `evt.preventDefault()`: Ngăn chặn hành vi mặc định đó.
  - `inputs[index + 1].focus()`: Tìm phần tử kế tiếp trong mảng danh sách ô nhập liệu và kích hoạt con trỏ chuột vào đó.

---

# 6. File: `2.6_danhsach.html` - Bảng nhân sự, Checkbox Select All & Highlight

```javascript
const selectAllCheckbox = document.getElementById('selectAll');
const checkboxes = document.querySelectorAll('.row-checkbox');
const rows = document.querySelectorAll('#employeeTable tbody tr');

// 1. Click vào ô tổng ở header để chọn/bỏ chọn tất cả
selectAllCheckbox.addEventListener('change', function () {
    checkboxes.forEach((cb, index) => {
        cb.checked = this.checked;
        updateRowHighlight(rows[index], cb.checked);
    });
});

// 2. Khi mỗi checkbox con thay đổi
checkboxes.forEach((checkbox, index) => {
    checkbox.addEventListener('change', function () {
        updateRowHighlight(rows[index], this.checked);
        updateSelectAll();
    });
});

// 3. Hàm cập nhật trạng thái checkbox tổng
function updateSelectAll() {
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    selectAllCheckbox.checked = allChecked;
}

// 4. Hàm tô màu nền dòng (Class .selected)
function updateRowHighlight(row, isChecked) {
    if (isChecked) {
        row.classList.add('selected');
    } else {
        row.classList.remove('selected');
    }
}

// 5. Click vào dòng cũng tương đương tick checkbox
rows.forEach((row, index) => {
    row.addEventListener('click', function (e) {
        if (e.target.type === 'checkbox') return;
        checkboxes[index].checked = !checkboxes[index].checked;
        updateRowHighlight(row, checkboxes[index].checked);
        updateSelectAll();
    });
});
```
- **Giải thích các kỹ thuật DOM hiện đại:**
  - `document.querySelectorAll(...)`: Lấy tất cả phần tử khớp bộ chọn và trả về một danh sách NodeList (có thể dùng hàm `.forEach()`).
  - `Array.from(checkboxes).every(cb => cb.checked)`: Phương thức `.every()` của mảng kiểm tra xem **tất cả** phần tử con có thỏa mãn điều kiện hay không. Chỉ cần 1 ô chưa được chọn, nó sẽ trả về `false`, giúp checkbox tổng tự bỏ dấu tick.
  - `if (e.target.type === 'checkbox') return;`: **Rất tinh tế!** Nếu người dùng click trực tiếp vào ô checkbox thì chính checkbox đã tự đảo trạng thái rồi. Lệnh `return` này giúp ngăn chặn việc sự kiện click dòng bị kích hoạt đè lên làm đảo trạng thái lần thứ hai (gây lỗi không thể bỏ chọn checkbox).

---

# 7. File: `2.7_thucdon.html` - Thực đơn chuyển đổi tiêu đề hiển thị

```javascript
const menuItems = document.querySelectorAll('.menu-items li');
const titleDisplay = document.getElementById('selected-task');
const descDisplay = document.getElementById('desc-task');

menuItems.forEach(item => {
    item.addEventListener('click', function () {
        // 1. Xóa class 'selected' khỏi tất cả các mục menu
        menuItems.forEach(i => i.classList.remove('selected'));

        // 2. Thêm class 'selected' cho mục vừa được click
        this.classList.add('selected');

        // 3. Lấy dữ liệu thuộc tính data-title và hiển thị sang khung bên phải
        const title = this.getAttribute('data-title');
        titleDisplay.textContent = `» ${title}`;
        descDisplay.textContent = `Tác vụ đang được kích hoạt bởi: Phạm Tiến Đạt (AT200311).`;
    });
});
```
- **Bản chất:**
  - `data-*` attribute (ở đây là `data-title`): Là chuẩn HTML5 cho phép lưu trữ dữ liệu tùy biến ngay trên thẻ HTML mà không ảnh hưởng đến giao diện.
  - `this.getAttribute('data-title')`: Lấy giá trị chuỗi mô tả từ thẻ `<li>` vừa được bấm và gán vào `titleDisplay.textContent` để cập nhật sang vùng hiển thị bên phải.
  - Dùng `textContent` thay vì `innerHTML` là tuân thủ nguyên tắc an toàn dữ liệu, chống tấn công XSS.

---

# 8. File: `2.8_tab.html` - Hệ thống Tab nội dung ngang

```javascript
const tabs = document.querySelectorAll('.tab');
const contents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.style.display = 'none');

        tab.classList.add('active');

        const target = tab.getAttribute('data-tab');
        const targetContent = document.getElementById(target);
        if (targetContent) {
            targetContent.style.display = 'block';
        }
    });
});

if (tabs.length > 0) {
    tabs[0].click(); // Giả lập click tab đầu tiên khi load
}
```
- **Bản chất:**
  - Mỗi tab chứa một thuộc tính `data-tab="tab1"`, tương ứng với thẻ nội dung có `id="tab1"`.
  - Cơ chế đồng bộ: Khi click tab nào, code ẩn toàn bộ nội dung của mọi tab trước bằng `c.style.display = 'none'`, sau đó chỉ làm hiện thẻ nội dung có `id` tương ứng bằng `style.display = 'block'`.
  - `tabs[0].click()`: Tự động kích hoạt tab số 1 ngay khi vào trang.

---

# 9. File: `2.9_cay.html` - Cây thư mục (Tree View) đóng mở đa cấp

```javascript
function toggleTree(btn) {
    var parentLi = btn.parentElement;
    var subUl = parentLi.querySelector("ul");

    if (subUl) {
        if (subUl.classList.contains("collapsed")) {
            subUl.classList.remove("collapsed");
            btn.textContent = "-";
        } else {
            subUl.classList.add("collapsed");
            btn.textContent = "+";
        }
    }
}

function selectNode(node) {
    var allNodes = document.querySelectorAll(".folder-node");
    allNodes.forEach(function(n) {
        n.classList.remove("selected-node");
    });
    node.classList.add("selected-node");

    var folderName = node.textContent.trim().replace("📁", "").replace("📂", "");
    document.getElementById("selected-info").innerHTML = 
        "Thư mục đang chọn: <strong>" + folderName + "</strong> (Người thao tác: Phạm Tiến Đạt - AT200311)";
}
```
- **Bản chất kỹ thuật duyệt cây phân cấp DOM:**
  - `btn.parentElement`: Truy cập từ nút bấm `<span>` ngược lên phần tử cha là thẻ `<li>`.
  - `parentLi.querySelector("ul")`: Tìm thẻ danh sách con `<ul>` nằm ngay bên trong thẻ `<li>` đó.
  - `classList.contains("collapsed")`: Kiểm tra thẻ con có đang mang class ẩn hay không. Nếu có thì gỡ bỏ class để mở ra và đổi nút thành `"-"`. Nếu đang mở thì thêm class `collapsed` (có CSS `display: none;`) để giấu đi và đổi nút thành `"+"`.

---

# 10. File: `2.10_maytinh.html` - Máy tính điện tử bỏ túi

```javascript
var currentVal = "0";      // Số đang hiển thị trên màn hình
var previousVal = "";     // Số thứ nhất lưu tạm trong bộ nhớ
var operation = null;     // Phép toán (+, -, *, /, %)
var resetScreen = false;  // Cờ báo hiệu có cần xóa màn hình khi gõ số mới không

function appendNumber(num) {
    if (currentVal === "0" || resetScreen) {
        currentVal = num;
        resetScreen = false;
    } else {
        currentVal += num;
    }
    updateDisplay();
}

function chooseOperator(op) {
    if (operation !== null) {
        calculate();
    }
    previousVal = currentVal;
    operation = op;
    resetScreen = true;
}

function calculate() {
    if (operation === null || resetScreen) return;
    var a = parseFloat(previousVal);
    var b = parseFloat(currentVal);
    var res = 0;

    switch (operation) {
        case "+": res = a + b; break;
        case "-": res = a - b; break;
        case "*": res = a * b; break;
        case "/": 
            if (b === 0) {
                alert("Lỗi: Không thể chia cho số 0!");
                clearAll();
                return;
            }
            res = a / b; 
            break;
        case "%": res = a % b; break;
        default: return;
    }

    res = Math.round(res * 100000000) / 100000000;
    currentVal = res.toString();
    operation = null;
    previousVal = "";
    resetScreen = true;
    updateDisplay();
}
```
- **Nguyên lý máy trạng thái (State Machine) của máy tính bỏ túi:**
  1. Người dùng bấm số: Hàm `appendNumber` nối chuỗi vào số hiện tại.
  2. Người dùng bấm dấu phép toán: Hàm `chooseOperator` lưu số hiện tại vào `previousVal`, lưu toán tử vào `operation`, và bật cờ `resetScreen = true`.
  3. Người dùng bấm số thứ hai: Do `resetScreen = true`, màn hình sẽ xóa số cũ và hiển thị số mới nhập.
  4. Người dùng bấm dấu `=`: Hàm `calculate` lấy 2 toán hạng `a` và `b`, thực hiện phép toán tương ứng bằng `switch...case`. Có cơ chế kiểm tra an toàn: nếu chia cho số 0 thì chặn lại và báo lỗi.

---

# 11. File: `2.11_hoatcanh.html` - Hoạt cảnh người que nhảy (Jump & Stop)

```javascript
let currentFrame = 0;
let direction = 1;     // 1: Chạy từ trái qua phải, -1: Chạy từ phải qua trái
let timerId = null;

function startJump() {
    if (timerId !== null) return; // Nếu đang chạy rồi thì không tạo thêm interval mới

    timerId = setInterval(function() {
        currentFrame += direction;

        // Nếu chạm khung hình cuối cùng bên phải -> Đảo hướng chạy lùi về trái
        if (currentFrame >= frames.length - 1) {
            currentFrame = frames.length - 1;
            direction = -1;
        }
        // Nếu chạm khung hình đầu tiên bên trái -> Đảo hướng chạy tiến sang phải
        else if (currentFrame <= 0) {
            currentFrame = 0;
            direction = 1;
        }

        box.innerHTML = frames[currentFrame];
    }, 180); // Lặp lại mỗi 180ms
}

function stopJump() {
    if (timerId !== null) {
        clearInterval(timerId); // Hủy bỏ bộ lặp
        timerId = null;
    }
}
```
- **Bản chất thuật toán Ping-Pong (Chạy qua chạy lại):**
  - Mảng `frames` chứa mã vẽ đồ họa vector SVG cho 4 trạng thái chuyển động của người que (đứng thẳng -> chùng chân -> bật nhảy -> tiếp đất).
  - `setInterval(hàm, 180)`: Lặp đi lặp lại hàm sau mỗi 180 mili-giây.
  - `currentFrame += direction`: Tăng hoặc giảm chỉ số khung hình. Khi chạm biên `length - 1`, ta đổi `direction = -1` (chạy ngược lại); khi chạm biên `0`, ta đổi `direction = 1` (chạy xuôi). Điều này đáp ứng chính xác yêu cầu đề bài: *"các hình vẽ sẽ thay đổi theo thứ tự từ trái sang phải và ngược lại"*.
  - `clearInterval(timerId)`: Lệnh hủy bỏ bộ đếm thời gian khi bấm nút Stop.

---

# 12. File: `2.12_sapxep_timkiem.html` - Sắp xếp bảng & Live Search Highlight

### 12.1. Sắp xếp động trên cột của bảng
```javascript
const table = document.getElementById('productTable');
const headers = table.querySelectorAll('th.sortable');
let sortDirection = {}; // Lưu trạng thái tăng/giảm cho từng cột

headers.forEach(header => {
    header.addEventListener('click', () => {
        const colIndex = parseInt(header.dataset.col);

        // Đảo chiều sắp xếp (true thành false, false thành true)
        sortDirection[colIndex] = !sortDirection[colIndex];

        headers.forEach(h => h.classList.remove('sorted-asc', 'sorted-desc'));

        const rows = Array.from(table.tBodies[0].rows);

        // Sắp xếp mảng dòng dữ liệu
        rows.sort((a, b) => {
            const cellA = a.cells[colIndex].textContent.trim().toLowerCase();
            const cellB = b.cells[colIndex].textContent.trim().toLowerCase();

            return sortDirection[colIndex]
                ? cellA.localeCompare(cellB, 'vi')
                : cellB.localeCompare(cellA, 'vi');
        });

        // Gắn lại các dòng đã sắp xếp vào bảng và cập nhật cột STT
        rows.forEach((row, i) => {
            row.cells[0].textContent = i + 1;
            table.tBodies[0].appendChild(row);
        });

        // Hiển thị mũi tên ▲ hoặc ▼
        header.classList.add(sortDirection[colIndex] ? 'sorted-asc' : 'sorted-desc');
    });
});
```
- **Bản chất:**
  - `Array.from(table.tBodies[0].rows)`: Chuyển đổi danh sách các dòng `HTMLCollection` thành một Mảng JavaScript chuẩn để sử dụng phương thức sắp xếp `.sort()`.
  - `cellA.localeCompare(cellB, 'vi')`: **Hàm so sánh chuỗi chuẩn quốc tế**. Nó hỗ trợ sắp xếp tiếng Việt có dấu (ví dụ chữ "Đ", "Ă", "Â") hoàn toàn chính xác theo bảng chữ cái.
  - `table.tBodies[0].appendChild(row)`: Trong DOM, khi gọi `appendChild` một phần tử đã có sẵn trong trang, trình duyệt sẽ tự động di chuyển phần tử đó đến vị trí mới mà không cần phải xóa đi tạo lại.

---

### 12.2. Tìm kiếm trực tiếp (Live Search) & Tô vàng (Highlight) từ khóa
```javascript
document.getElementById('searchInput').addEventListener('input', function () {
    const keyword = this.value.trim().toLowerCase();
    const rows = table.tBodies[0].rows;

    for (let row of rows) {
        let found = false;

        for (let i = 1; i < row.cells.length; i++) {
            const cell = row.cells[i];
            const text = cell.textContent;
            const lower = text.toLowerCase();

            if (keyword && lower.includes(keyword)) {
                found = true;
                // Escape các ký tự đặc biệt trong từ khóa
                const escaped = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const regex = new RegExp(`(${escaped})`, 'gi');
                cell.innerHTML = text.replace(regex, '<span class="highlight">$1</span>');
            } else {
                cell.innerHTML = text;
            }
        }

        // Ẩn hoặc hiện dòng
        row.style.display = found || keyword === "" ? "" : "none";
    }
});
```
- **Bản chất:**
  - Lắng nghe sự kiện `'input'`: Sự kiện này phản hồi tức thời ngay khi người dùng gõ từng phím hoặc dán văn bản vào ô tìm kiếm.
  - `lower.includes(keyword)`: Kiểm tra xem ô có chứa từ khóa hay không (không phân biệt hoa thường).
  - `cell.innerHTML = text.replace(regex, '<span class="highlight">$1</span>')`: Dùng Regex tìm cụm từ khớp và bọc cụm từ đó lại bằng thẻ `<span class="highlight">` (được định nghĩa trong CSS với thuộc tính `background-color: yellow`). Nhờ đó, từ khóa được tìm thấy sẽ nổi bật rực rỡ trên màn hình!
  - `row.style.display = found || keyword === "" ? "" : "none"`: Dùng toán tử ba ngôi để quyết định: nếu tìm thấy từ khóa hoặc ô tìm kiếm rỗng thì để trống `""` (hiển thị bình thường), ngược lại gán `"none"` để ẩn dòng đó đi.

---

# TỔNG KẾT KINH NGHIỆM KHI BẢO VỆ BÀI TẬP
1. **Nếu thầy cô hỏi:** *"Tại sao em lại dùng `trim()` ở khắp mọi nơi?"*  
   👉 **Trả lời:** Dạ thưa thầy/cô, `trim()` giúp làm sạch dữ liệu đầu vào, loại bỏ khoảng trắng vô tình ở đầu và cuối do người dùng gõ phím, đảm bảo việc kiểm tra rỗng và độ dài chuỗi trong cơ sở dữ liệu (`Char(6)`, `Char(50)`) đạt độ chính xác cao nhất.

2. **Nếu thầy cô hỏi:** *"Làm sao em ngăn form tự động submit khi bấm phím Enter?"*  
   👉 **Trả lời:** Dạ em bắt sự kiện `onkeydown` trên các ô input, kiểm tra mã phím `evt.keyCode === 13` và gọi `evt.preventDefault()` để hủy hành vi submit mặc định của trình duyệt, sau đó dùng lệnh `.focus()` chuyển điều khiển sang ô kế tiếp.

3. **Nếu thầy cô hỏi:** *"Cơ chế sắp xếp tiếng Việt của em hoạt động thế nào?"*  
   👉 **Trả lời:** Dạ em sử dụng hàm `.localeCompare(b, 'vi')` có chỉ định ngôn ngữ tiếng Việt để so sánh chuỗi theo đúng quy chuẩn bảng chữ cái tiếng Việt có dấu.
