<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 15: CARTADD.PHP
// ========================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $product = null;
    if (isset($conn) && $conn) {
        $r = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
        if ($r && $row = mysqli_fetch_assoc($r)) {
            $product = $row;
        }
    }
    if (!$product && isset($SAMPLE_PRODUCTS[$id])) {
        $product = $SAMPLE_PRODUCTS[$id];
    }

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $product['id'],
                'name' => $product['product_name'],
                'price' => $product['price'],
                'image' => $product['image'] ?? 'dell_vostro.jpg',
                'qty' => 1
            ];
        }
    }
}

header("Location: cartView.php");
exit();
?>
