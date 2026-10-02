<h3>Upload nhiều file sử dụng mảng kết hợp</h3>
<p style="color: #475569; font-size: 14px; margin: 8px 0 15px 0;">
    (Bài toán: Upload 10 file cùng lúc bằng mảng input <code>files[]</code>, in danh sách tên 10 file và đường dẫn download file)
</p>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px; max-width: 550px;">
    <form method="POST" action="index.php?page=uploadprocess" enctype="multipart/form-data">
        <table border="0" cellpadding="6" style="width: 100%;">
            <?php
            for ($i = 1; $i <= 10; $i++) {
                echo "<tr>";
                echo "<td style='width: 80px; font-weight: bold;'>File $i:</td>";
                echo "<td><input type='file' name='files[]' style='width: 100%; border: 1px solid #e2e8f0; padding: 4px; border-radius: 4px;'></td>";
                echo "</tr>";
            }
            ?>
            <tr>
                <td colspan="2" style="padding-top: 15px;">
                    <button type="reset">Nhập Lại</button>
                    <input type="submit" name="submit" value="Upload" style="padding: 7px 22px; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                </td>
            </tr>
        </table>
    </form>
</div>
