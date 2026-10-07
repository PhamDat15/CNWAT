<?php
/**
 * Model Order: Quản lý đơn hàng và thống kê doanh thu
 */

require_once __DIR__ . '/../core/Model.php';

class Order extends Model {
    public function createOrder(?int $userId, string $name, string $phone, string $address, ?string $notes, array $items, float $totalAmount): int {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
                INSERT INTO orders (user_id, customer_name, customer_phone, customer_address, customer_notes, total_amount, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, 'pending', ?)
            ");
            $stmt->execute([$userId, $name, $phone, $address, $notes, $totalAmount, date('Y-m-d H:i:s')]);
            $orderId = (int)$this->db->lastInsertId();

            $stmtItem = $this->db->prepare("
                INSERT INTO order_items (order_id, product_id, product_name, price, quantity)
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($items as $item) {
                $stmtItem->execute([
                    $orderId,
                    $item['id'],
                    $item['name'],
                    $item['price'],
                    $item['quantity']
                ]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getAllOrders(): array {
        return $this->fetchAll("SELECT * FROM orders ORDER BY id DESC");
    }

    public function getUserOrders(int $userId): array {
        return $this->fetchAll("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC", [$userId]);
    }

    public function getOrderById(int $id): ?array {
        return $this->fetchOne("SELECT * FROM orders WHERE id = ?", [$id]);
    }

    public function getOrderItems(int $orderId): array {
        return $this->fetchAll("SELECT * FROM order_items WHERE order_id = ?", [$orderId]);
    }

    public function updateStatus(int $id, string $status): bool {
        $stmt = $this->execute("UPDATE orders SET status = ? WHERE id = ?", [$status, $id]);
        return $stmt->rowCount() > 0;
    }

    public function countOrders(): int {
        return $this->count("SELECT COUNT(*) FROM orders");
    }

    public function getTotalRevenue(): float {
        $val = $this->fetchOne("SELECT SUM(total_amount) as total FROM orders WHERE status != 'cancelled'");
        return (float)($val['total'] ?? 0);
    }
}
