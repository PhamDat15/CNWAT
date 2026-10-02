<div class="form-title">Form Dang ky</div>
<form name="form1" action="index.php?page=registerProcess" method="post">
    <table class="data-table" cellpadding="0" cellspacing="0">
        <tr>
            <td>Username:</td>
            <td>
                <input name="txtUsername" type="text" id="txtUsername" size="40" placeholder="Nhập tên đăng nhập..." required>
            </td>
        </tr>
        <tr>
            <td>Password:</td>
            <td>
                <input name="txtPassword" type="password" id="txtPassword" size="40" placeholder="Nhập mật khẩu..." required>
            </td>
        </tr>
        <tr>
            <td>Gender:</td>
            <td>
                <label style="margin-right: 15px;"><input type="radio" name="radGender" value="Male" checked> Male</label>
                <label><input type="radio" name="radGender" value="Female"> Female</label>
            </td>
        </tr>
        <tr>
            <td>Address:</td>
            <td>
                <select name="lstAddress" size="4" id="lstAddress" style="width: 220px;" required>
                    <option value="Ha Noi" selected>Ha Noi</option>
                    <option value="TP. HCM">TP. HCM</option>
                    <option value="Hue">Hue</option>
                    <option value="Da Nang">Da Nang</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Enable Programming Language:</td>
            <td style="display: flex; gap: 15px; flex-wrap: wrap;">
                <label><input name="chkLang[]" type="checkbox" value="PHP" checked> PHP</label>
                <label><input name="chkLang[]" type="checkbox" value="C#" checked> C#</label>
                <label><input name="chkLang[]" type="checkbox" value="Java"> Java</label>
                <label><input name="chkLang[]" type="checkbox" value="C++"> C++</label>
            </td>
        </tr>
        <tr>
            <td>Skill:</td>
            <td>
                <label style="margin-right: 15px;"><input type="radio" name="radSkill" value="Normal"> Normal</label>
                <label style="margin-right: 15px;"><input type="radio" name="radSkill" value="Good"> Good</label>
                <label style="margin-right: 15px;"><input type="radio" name="radSkill" value="Very Good" checked> Very Good</label>
                <label><input type="radio" name="radSkill" value="Excellent"> Excellent</label>
            </td>
        </tr>
        <tr>
            <td>Note:</td>
            <td>
                <textarea name="taNote" cols="40" rows="3" id="taNote" placeholder="Ghi chú thêm..."></textarea>
            </td>
        </tr>
        <tr>
            <td>Marriage Status:</td>
            <td>
                <label><input name="chkMariageStatus" type="checkbox" id="chkMariageStatus" value="Da ket hon"> Đã kết hôn</label>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; padding: 15px 10px;">
                <input type="reset" name="Reset" value="Reset" style="margin-right: 10px;">
                <input type="submit" name="btnRegister" id="btnRegister" value="Register">
            </td>
        </tr>
    </table>
</form>
