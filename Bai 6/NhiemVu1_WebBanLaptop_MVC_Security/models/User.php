<?php
/**
 * Model User: Quản lý người dùng và phân quyền (Role: admin, customer)
 */

require_once __DIR__ . '/../core/Model.php';

class User extends Model {
    public function findByUsername(string $username): ?array {
        return $this->fetchOne("SELECT * FROM users WHERE username = ?", [$username]);
    }

    public function findByEmail(string $email): ?array {
        return $this->fetchOne("SELECT * FROM users WHERE email = ?", [$email]);
    }

    public function findById(int $id): ?array {
        return $this->fetchOne("SELECT * FROM users WHERE id = ?", [$id]);
    }

    public function getAll(): array {
        return $this->fetchAll("SELECT id, username, fullname, email, role, created_at FROM users ORDER BY id DESC");
    }

    public function create(string $username, string $passwordHash, string $fullname, string $email, string $role = 'customer'): int {
        $sql = "INSERT INTO users (username, password, fullname, email, role, created_at) VALUES (?, ?, ?, ?, ?, ?)";
        $this->execute($sql, [$username, $passwordHash, $fullname, $email, $role, date('Y-m-d H:i:s')]);
        return (int)$this->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE users SET fullname = ?, email = ?, role = ? WHERE id = ?";
        $stmt = $this->execute($sql, [$data['fullname'], $data['email'], $data['role'], $id]);
        return $stmt->rowCount() > 0;
    }

    public function updatePassword(int $id, string $newPasswordHash): bool {
        $stmt = $this->execute("UPDATE users SET password = ? WHERE id = ?", [$newPasswordHash, $id]);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool {
        $stmt = $this->execute("DELETE FROM users WHERE id = ?", [$id]);
        return $stmt->rowCount() > 0;
    }

    public function countUsers(): int {
        return $this->count("SELECT COUNT(*) FROM users");
    }
}
