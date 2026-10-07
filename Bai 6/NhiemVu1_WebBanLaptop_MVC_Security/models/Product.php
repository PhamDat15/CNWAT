<?php
/**
 * Model Product: Xử lý dữ liệu sản phẩm Laptop bằng Prepared Statements
 */

require_once __DIR__ . '/../core/Model.php';

class Product extends Model {
    public function getAll(int $limit = 12, int $offset = 0, array $filters = []): array {
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];

        if (!empty($filters['brand'])) {
            $sql .= " AND brand = ?";
            $params[] = $filters['brand'];
        }

        if (!empty($filters['min_price'])) {
            $sql .= " AND price >= ?";
            $params[] = (float)$filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $sql .= " AND price <= ?";
            $params[] = (float)$filters['max_price'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (name LIKE ? OR short_desc LIKE ? OR brand LIKE ?)";
            $keyword = '%' . $filters['search'] . '%';
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        return $this->fetchAll($sql, $params);
    }

    public function countFiltered(array $filters = []): int {
        $sql = "SELECT COUNT(*) FROM products WHERE 1=1";
        $params = [];

        if (!empty($filters['brand'])) {
            $sql .= " AND brand = ?";
            $params[] = $filters['brand'];
        }

        if (!empty($filters['min_price'])) {
            $sql .= " AND price >= ?";
            $params[] = (float)$filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $sql .= " AND price <= ?";
            $params[] = (float)$filters['max_price'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (name LIKE ? OR short_desc LIKE ? OR brand LIKE ?)";
            $keyword = '%' . $filters['search'] . '%';
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        return $this->count($sql, $params);
    }

    public function getById(int $id): ?array {
        return $this->fetchOne("SELECT * FROM products WHERE id = ?", [$id]);
    }

    /**
     * Lấy 2 sản phẩm mới nhất của từng hãng (theo đúng yêu cầu của Đề bài 4 & 6)
     */
    public function getLatestByBrands(): array {
        $brands = ['Dell', 'Asus', 'HP', 'Apple', 'Lenovo', 'Acer'];
        $result = [];

        foreach ($brands as $brand) {
            $items = $this->fetchAll("SELECT * FROM products WHERE brand = ? ORDER BY id DESC LIMIT 2", [$brand]);
            if (!empty($items)) {
                $result[$brand] = $items;
            }
        }

        return $result;
    }

    public function getFeatured(int $limit = 4): array {
        return $this->fetchAll("SELECT * FROM products ORDER BY price DESC LIMIT ?", [$limit]);
    }

    public function getRelated(string $brand, int $excludeId, int $limit = 4): array {
        return $this->fetchAll("SELECT * FROM products WHERE brand = ? AND id != ? ORDER BY id DESC LIMIT ?", [$brand, $excludeId, $limit]);
    }

    public function searchLive(string $keyword, int $limit = 6): array {
        $k = '%' . $keyword . '%';
        return $this->fetchAll(
            "SELECT id, name, brand, price, image FROM products WHERE name LIKE ? OR brand LIKE ? ORDER BY id DESC LIMIT ?",
            [$k, $k, $limit]
        );
    }

    public function create(array $data): int {
        $sql = "INSERT INTO products (name, brand, price, old_price, quantity, image, short_desc, description, specs_cpu, specs_ram, specs_storage, specs_screen, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->execute($sql, [
            $data['name'],
            $data['brand'],
            $data['price'],
            $data['old_price'] ?? null,
            $data['quantity'] ?? 10,
            $data['image'],
            $data['short_desc'] ?? '',
            $data['description'] ?? '',
            $data['specs_cpu'] ?? '',
            $data['specs_ram'] ?? '',
            $data['specs_storage'] ?? '',
            $data['specs_screen'] ?? '',
            $data['created_at'] ?? date('Y-m-d H:i:s')
        ]);

        return (int)$this->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE products SET name = ?, brand = ?, price = ?, old_price = ?, quantity = ?, image = ?, short_desc = ?, description = ?, specs_cpu = ?, specs_ram = ?, specs_storage = ?, specs_screen = ? WHERE id = ?";
        
        $stmt = $this->execute($sql, [
            $data['name'],
            $data['brand'],
            $data['price'],
            $data['old_price'] ?? null,
            $data['quantity'] ?? 10,
            $data['image'],
            $data['short_desc'] ?? '',
            $data['description'] ?? '',
            $data['specs_cpu'] ?? '',
            $data['specs_ram'] ?? '',
            $data['specs_storage'] ?? '',
            $data['specs_screen'] ?? '',
            $id
        ]);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool {
        $stmt = $this->execute("DELETE FROM products WHERE id = ?", [$id]);
        return $stmt->rowCount() > 0;
    }
}
