<?php

namespace App\Http\Controllers;

use LaravelKernel;
use PDO;

class ContactController
{
    private PDO $db;

    public function __construct() {
        LaravelKernel::init();
        $this->db = LaravelKernel::getDb();
    }

    public function index(): void {
        $search = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? '');

        $sql = "SELECT * FROM contacts WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (name LIKE ? OR phone LIKE ? OR email LIKE ?)";
            $keyword = '%' . $search . '%';
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        if (!empty($category)) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $contacts = $stmt->fetchAll();

        // Tổng số liên hệ
        $totalContacts = (int)$this->db->query("SELECT COUNT(*) FROM contacts")->fetchColumn();

        LaravelKernel::renderBlade('contacts.index', [
            'contacts' => $contacts,
            'search' => $search,
            'category' => $category,
            'totalContacts' => $totalContacts
        ]);
    }

    public function create(): void {
        LaravelKernel::renderBlade('contacts.create', [
            'errors' => [],
            'old' => []
        ]);
    }

    public function store(): void {
        if (!LaravelKernel::validateCsrf()) {
            die('Lỗi bảo mật 403: CSRF Token không hợp lệ!');
        }

        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $category = trim($_POST['category'] ?? 'Bạn bè');
        $birthdate = !empty($_POST['birthdate']) ? trim($_POST['birthdate']) : null;
        $notes = trim($_POST['notes'] ?? '');

        $errors = [];
        if (empty($name) || mb_strlen($name) < 2) {
            $errors[] = 'Họ và tên bắt buộc phải có ít nhất 2 ký tự.';
        }
        if (empty($phone) || !preg_match('/^(0[3|5|7|8|9])[0-9]{8}$/', $phone)) {
            $errors[] = 'Số điện thoại không hợp lệ (Phải là 10 chữ số đầu số Việt Nam).';
        }
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Địa chỉ Email không đúng định dạng.';
        }

        // Upload Avatar
        $avatarName = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES['avatar']['tmp_name']);
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];

            if (!in_array($mime, $allowed)) {
                $errors[] = 'Ảnh đại diện phải là file JPG, PNG hoặc WEBP.';
            } elseif ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
                $errors[] = 'Kích thước ảnh đại diện không được vượt quá 2MB.';
            } else {
                $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $avatarName = 'avatar_' . bin2hex(random_bytes(8)) . '.' . $ext;
                $targetDir = __DIR__ . '/../../public/uploads/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }
                move_uploaded_file($_FILES['avatar']['tmp_name'], $targetDir . $avatarName);
            }
        }

        if (!empty($errors)) {
            LaravelKernel::renderBlade('contacts.create', [
                'errors' => $errors,
                'old' => $_POST
            ]);
            return;
        }

        $stmt = $this->db->prepare("
            INSERT INTO contacts (name, phone, email, address, category, birthdate, notes, avatar, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, datetime('now', 'localtime'), datetime('now', 'localtime'))
        ");
        
        // Thử execute với datetime fallback (hoặc NOW())
        try {
            $stmt->execute([$name, $phone, $email, $address, $category, $birthdate, $notes, $avatarName]);
        } catch (\Exception $e) {
            $stmt2 = $this->db->prepare("
                INSERT INTO contacts (name, phone, email, address, category, birthdate, notes, avatar, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            $stmt2->execute([$name, $phone, $email, $address, $category, $birthdate, $notes, $avatarName]);
        }

        $_SESSION['_flash']['success'] = "Đã thêm liên hệ '{$name}' vào danh bạ thành công!";
        header("Location: index.php");
        exit;
    }

    public function show(int $id): void {
        $stmt = $this->db->prepare("SELECT * FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        $contact = $stmt->fetch();

        if (!$contact) {
            $_SESSION['_flash']['error'] = 'Liên hệ không tồn tại!';
            header("Location: index.php");
            exit;
        }

        LaravelKernel::renderBlade('contacts.show', [
            'contact' => $contact
        ]);
    }

    public function edit(int $id): void {
        $stmt = $this->db->prepare("SELECT * FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        $contact = $stmt->fetch();

        if (!$contact) {
            $_SESSION['_flash']['error'] = 'Liên hệ không tồn tại!';
            header("Location: index.php");
            exit;
        }

        LaravelKernel::renderBlade('contacts.edit', [
            'contact' => $contact,
            'errors' => []
        ]);
    }

    public function update(int $id): void {
        if (!LaravelKernel::validateCsrf()) {
            die('Lỗi bảo mật 403: CSRF Token không hợp lệ!');
        }

        $stmt = $this->db->prepare("SELECT * FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        $contact = $stmt->fetch();

        if (!$contact) {
            header("Location: index.php");
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $category = trim($_POST['category'] ?? 'Bạn bè');
        $birthdate = !empty($_POST['birthdate']) ? trim($_POST['birthdate']) : null;
        $notes = trim($_POST['notes'] ?? '');

        $errors = [];
        if (empty($name)) $errors[] = 'Họ và tên không được để trống.';
        if (empty($phone) || !preg_match('/^(0[3|5|7|8|9])[0-9]{8}$/', $phone)) {
            $errors[] = 'Số điện thoại không hợp lệ.';
        }

        $avatarName = $contact['avatar'];
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES['avatar']['tmp_name']);
            if (in_array($mime, ['image/jpeg', 'image/png', 'image/webp'])) {
                $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $avatarName = 'avatar_' . bin2hex(random_bytes(8)) . '.' . $ext;
                $targetDir = __DIR__ . '/../../public/uploads/';
                move_uploaded_file($_FILES['avatar']['tmp_name'], $targetDir . $avatarName);
            }
        }

        if (!empty($errors)) {
            LaravelKernel::renderBlade('contacts.edit', [
                'contact' => array_merge($contact, $_POST),
                'errors' => $errors
            ]);
            return;
        }

        $stmtUpdate = $this->db->prepare("
            UPDATE contacts SET name = ?, phone = ?, email = ?, address = ?, category = ?, birthdate = ?, notes = ?, avatar = ? WHERE id = ?
        ");
        $stmtUpdate->execute([$name, $phone, $email, $address, $category, $birthdate, $notes, $avatarName, $id]);

        $_SESSION['_flash']['success'] = "Cập nhật liên hệ '{$name}' thành công!";
        header("Location: index.php?r=contacts/show&id={$id}");
        exit;
    }

    public function destroy(): void {
        if (!LaravelKernel::validateCsrf()) {
            die('Lỗi bảo mật 403: CSRF Token không hợp lệ!');
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $this->db->prepare("DELETE FROM contacts WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['_flash']['success'] = "Đã xóa liên hệ khỏi danh bạ thành công!";
        }
        header("Location: index.php");
        exit;
    }

    public function exportCsv(): void {
        $stmt = $this->db->query("SELECT id, name, phone, email, category, birthdate, address, notes FROM contacts ORDER BY id ASC");
        $contacts = $stmt->fetchAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="contacts_laravel_export_' . date('Ymd_His') . '.csv"');

        $out = fopen('php://output', 'w');
        // Ghi UTF-8 BOM để Excel hiển thị tiếng Việt không bị lỗi font
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($out, ['ID', 'Họ và tên', 'Số điện thoại', 'Email', 'Phân loại', 'Ngày sinh', 'Địa chỉ', 'Ghi chú']);

        foreach ($contacts as $c) {
            fputcsv($out, [
                $c['id'],
                $c['name'],
                $c['phone'],
                $c['email'],
                $c['category'],
                $c['birthdate'],
                $c['address'],
                $c['notes']
            ]);
        }

        fclose($out);
        exit;
    }
}
