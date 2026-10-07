<?php
/**
 * Base Model: Hỗ trợ truy vấn dữ liệu chuẩn mực bằng PDO Prepared Statements
 */

require_once __DIR__ . '/Database.php';

abstract class Model {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Thực thi truy vấn Prepared Statement và trả về PDOStatement
     */
    protected function execute(string $sql, array $params = []): PDOStatement {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Lấy 1 bản ghi
     */
    protected function fetchOne(string $sql, array $params = []): ?array {
        $stmt = $this->execute($sql, $params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Lấy tất cả bản ghi
     */
    protected function fetchAll(string $sql, array $params = []): array {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Lấy ID của bản ghi vừa chèn
     */
    protected function lastInsertId(): string {
        return $this->db->lastInsertId();
    }

    /**
     * Đếm số lượng bản ghi
     */
    protected function count(string $sql, array $params = []): int {
        $stmt = $this->execute($sql, $params);
        return (int)$stmt->fetchColumn();
    }
}
