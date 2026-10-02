<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL
// NHIỆM VỤ 2: SỬ DỤNG TEMPLATE - TRANG REGISTER.PHP
// ========================================================
include 'header.php';
?>

<h3 style="text-align:center; color: #1e40af; margin-bottom: 20px;">Form Đăng Ký</h3>

<form action="result_register.php" method="POST">
    <table class="form-table" align="center" border="0">
        <tr>
            <td style="font-weight: bold; width: 90px;">Tên:</td>
            <td><input type="text" name="ten" size="30" placeholder="Nhập họ và tên..." required></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Địa chỉ:</td>
            <td><input type="text" name="dia_chi" size="30" placeholder="Nhập địa chỉ cư trú..." required></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nghề:</td>
            <td><input type="text" name="nghe" size="30" placeholder="Nhập nghề nghiệp..." required></td>
        </tr>
        <tr>
            <td style="font-weight: bold; vertical-align: top;">Ghi chú:</td>
            <td><textarea name="ghi_chu" rows="4" cols="32" placeholder="Ghi chú thêm kinh nghiệm, sở thích..."></textarea></td>
        </tr>
        <tr>
            <td colspan="2" class="btn-group">
                <input type="reset" value="Xóa">
                <input type="submit" value="Đăng Ký">
            </td>
        </tr>
    </table>
</form>

<?php include 'footer.php'; ?>
