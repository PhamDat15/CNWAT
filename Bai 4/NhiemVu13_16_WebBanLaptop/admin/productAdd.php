<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 16: TÍCH HỢP RICHTEXT BOX
// FILE: PRODUCTADD.PHP
// ========================================================
include 'header.php';

$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$name = "";
$price = "";
$cat_id = 1;
$production = "DELL";
$desc = "CPU Intel Core 2 Duo T6670 2.2GHz, RAM 2GB DDR2, HDD 500GB, Màn hình 14.1 inch WLED display, VGA Intel Graphics, Pin 6 cell, Trọng lượng 2.1kg.";
$img = "dell_vostro.jpg";
$is_edit = false;

if (isset($conn) && $conn && $edit_id > 0) {
    $q = mysqli_query($conn, "SELECT * FROM products WHERE id = $edit_id");
    if ($q && $row = mysqli_fetch_assoc($q)) {
        $is_edit = true;
        $name = $row['product_name'];
        $price = $row['price'];
        $cat_id = $row['cat_id'];
        $desc = $row['description'];
        $img = $row['image'];
    }
}

// Xử lý lưu dữ liệu
if (isset($_POST['btnSave'])) {
    $p_name = trim($_POST['name'] ?? '');
    $p_price = floatval($_POST['price'] ?? 0);
    $p_cat = intval($_POST['cat_id'] ?? 1);
    $p_desc = trim($_POST['txtDescription'] ?? '');
    $p_img = $img;

    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $clean = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/images/' . $clean)) {
            $p_img = $clean;
        }
    }

    if (isset($conn) && $conn) {
        $n_safe = mysqli_real_escape_string($conn, $p_name);
        $d_safe = mysqli_real_escape_string($conn, $p_desc);
        if ($is_edit) {
            $sql = "UPDATE products SET product_name='$n_safe', price=$p_price, cat_id=$p_cat, description='$d_safe', image='$p_img' WHERE id=$edit_id";
        } else {
            $sql = "INSERT INTO products (product_name, price, cat_id, description, image) VALUES ('$n_safe', $p_price, $p_cat, '$d_safe', '$p_img')";
        }
        mysqli_query($conn, $sql);
    }
    echo "<script>alert('Lưu sản phẩm thành công!'); window.location.href='productList.php';</script>";
    exit();
}
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 25px; max-width: 750px;">
    <h3 style="color: #1e40af; margin-bottom: 18px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">
        <?php echo $is_edit ? "Sửa Sản Phẩm (Product Edit)" : "Add news Product (Tích hợp Rich Text Box CKEditor)"; ?>
    </h3>

    <form method="POST" action="" enctype="multipart/form-data" id="productForm">
        <table border="0" cellpadding="8" style="width: 100%;">
            <tr>
                <td style="width: 110px; font-weight: bold;">Name:</td>
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($name ?: 'Laptop Dell Vostro 1014'); ?>" style="width: 100%; padding: 6px;" required></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Price:</td>
                <td>
                    <input type="number" name="price" value="<?php echo htmlspecialchars($price ?: '8699000'); ?>" style="width: 250px; padding: 6px;" required> VNĐ
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Image:</td>
                <td>
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <img src="images/<?php echo htmlspecialchars($img); ?>" style="width: 65px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc;" onerror="this.src='images/dell_vostro.jpg'">
                        <input type="file" name="image" style="font-size: 13px;">
                    </div>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; vertical-align: top;">Description:</td>
                <td>
                    <!-- WYSIWYG / CKEditor Rich Text Box Interface -->
                    <div style="border: 1px solid #cbd5e1; border-radius: 4px;">
                        <!-- Rich Text Toolbar mô phỏng CKEditor theo tài liệu trang 65/66 -->
                        <div class="editor-toolbar" style="background: #f1f5f9; padding: 6px; border-bottom: 1px solid #cbd5e1; display: flex; gap: 5px; flex-wrap: wrap;">
                            <button type="button" class="editor-btn" onclick="execCmd('bold')"><b>B</b></button>
                            <button type="button" class="editor-btn" onclick="execCmd('italic')"><i>I</i></button>
                            <button type="button" class="editor-btn" onclick="execCmd('underline')"><u>U</u></button>
                            <button type="button" class="editor-btn" onclick="execCmd('strikeThrough')"><s>S</s></button>
                            <span style="border-right: 1px solid #cbd5e1; margin: 0 4px;"></span>
                            <button type="button" class="editor-btn" onclick="execCmd('insertUnorderedList')">&bull; List</button>
                            <button type="button" class="editor-btn" onclick="execCmd('insertOrderedList')">1. List</button>
                            <span style="border-right: 1px solid #cbd5e1; margin: 0 4px;"></span>
                            <button type="button" class="editor-btn" onclick="execCmd('justifyLeft')">&equiv; Trái</button>
                            <button type="button" class="editor-btn" onclick="execCmd('justifyCenter')">&equiv; Giữa</button>
                            <button type="button" class="editor-btn" onclick="execCmd('justifyRight')">&equiv; Phải</button>
                            <span style="border-right: 1px solid #cbd5e1; margin: 0 4px;"></span>
                            <select onchange="execCmdArg('formatBlock', this.value)" style="padding: 2px 4px; font-size: 12px;">
                                <option value="p">Paragraph</option>
                                <option value="h3">Heading 3</option>
                                <option value="h4">Heading 4</option>
                            </select>
                            <span style="font-size: 11px; color: #64748b; align-self: center; margin-left: auto;">[CKEditor Visual Bar]</span>
                        </div>

                        <!-- Editable Content Area -->
                        <div id="richEditor" contenteditable="true" style="min-height: 160px; padding: 12px; outline: none; line-height: 1.6; font-size: 14px; background: white;" oninput="syncEditor()">
                            <?php echo nl2br(htmlspecialchars($desc)); ?>
                        </div>

                        <!-- Hidden Textarea đồng bộ dữ liệu gửi lên server -->
                        <textarea name="txtDescription" id="txtDescription" style="display: none;"><?php echo htmlspecialchars($desc); ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Category:</td>
                <td>
                    <select name="cat_id" style="width: 250px; padding: 6px;">
                        <?php foreach ($categories as $c): ?>
                            <option value="<?php echo $c['id']; ?>" <?php echo ($cat_id == $c['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($c['cat_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span style="font-size: 12px; color: #dc2626; margin-left: 10px;">* Loại sản phẩm lấy từ database</span>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Production:</td>
                <td>
                    <select name="production" style="width: 250px; padding: 6px;">
                        <option value="DELL" selected>DELL</option>
                        <option value="HP">HP</option>
                        <option value="IBM">IBM / Lenovo</option>
                        <option value="ASUS">ASUS</option>
                        <option value="APPLE">Apple Inc.</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 15px;">
                    <input type="reset" value="Reset" style="padding: 6px 18px; margin-right: 8px;">
                    <input type="submit" name="btnSave" value="Save" style="padding: 6px 26px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                </td>
            </tr>
        </table>
    </form>
</div>

<script>
function execCmd(command) {
    document.execCommand(command, false, null);
    syncEditor();
}
function execCmdArg(command, arg) {
    document.execCommand(command, false, arg);
    syncEditor();
}
function syncEditor() {
    const editor = document.getElementById('richEditor');
    const textarea = document.getElementById('txtDescription');
    textarea.value = editor.innerText || editor.textContent;
}
document.getElementById('productForm').addEventListener('submit', function() {
    syncEditor();
});
</script>

<?php include 'footer.php'; ?>
