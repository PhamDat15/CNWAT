<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - NHIỆM VỤ 15: CARTVIEW.PHP
// ========================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/connect.php';

// Xử lý cập nhật số lượng
if (isset($_POST['btnUpdateCart'])) {
    if (isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $pid => $q) {
            $q = intval($q);
            if ($q <= 0) {
                unset($_SESSION['cart'][$pid]);
            } else {
                $_SESSION['cart'][$pid]['qty'] = $q;
            }
        }
    }
}

// Xóa 1 sản phẩm
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cartView.php");
    exit();
}

// Xóa sạch giỏ hàng
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: cartView.php");
    exit();
}

include 'header.php';
$cart = $_SESSION['cart'] ?? [];
$grand_total = 0;
?>

<div style="background: white; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #b91c1c; padding-bottom: 8px; margin-bottom: 15px;">
        <h3 style="color: #b91c1c; margin: 0; font-size: 18px;">🛒 GIỎ HÀNG CỦA BẠN (SHOPPING CART)</h3>
        <a href="productList.php" style="color: #2563eb; font-size: 13px; text-decoration: underline;">&larr; Tiếp tục mua sắm</a>
    </div>

    <?php if (!empty($cart)): ?>
        <form method="POST" action="cartView.php">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th style="width: 70px; text-align: center;">Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th style="width: 130px; text-align: right;">Đơn giá</th>
                        <th style="width: 90px; text-align: center;">Số lượng</th>
                        <th style="width: 140px; text-align: right;">Thành tiền</th>
                        <th style="width: 70px; text-align: center;">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $id => $item): 
                        $total = $item['price'] * $item['qty'];
                        $grand_total += $total;
                    ?>
                    <tr>
                        <td style="text-align: center;">
                            <img src="images/<?php echo htmlspecialchars($item['image']); ?>" style="width: 50px; height: 40px; object-fit: cover; border-radius: 3px;" onerror="this.src='images/dell_vostro.jpg'">
                        </td>
                        <td>
                            <a href="productDetail.php?id=<?php echo $id; ?>" style="color: #1e3a8a; font-weight: bold; text-decoration: none;">
                                <?php echo htmlspecialchars($item['name']); ?>
                            </a>
                        </td>
                        <td style="text-align: right; font-weight: bold; color: #475569;">
                            <?php echo number_format($item['price'], 0, ',', '.'); ?> đ
                        </td>
                        <td style="text-align: center;">
                            <input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $item['qty']; ?>" min="1" max="99" style="width: 55px; text-align: center; padding: 4px; border: 1px solid #cbd5e1; border-radius: 3px; font-weight: bold;">
                        </td>
                        <td style="text-align: right; font-weight: bold; color: #dc2626;">
                            <?php echo number_format($total, 0, ',', '.'); ?> đ
                        </td>
                        <td style="text-align: center;">
                            <a href="cartView.php?remove=<?php echo $id; ?>" onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?');" style="color: #dc2626; font-size: 16px; text-decoration: none;">&times;</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background: #f8fafc;">
                        <td colspan="4" style="text-align: right; font-weight: bold; font-size: 15px; color: #1e293b;">
                            TỔNG TIỀN THANH TOÁN (TẠM TÍNH):
                        </td>
                        <td style="text-align: right; font-size: 18px; font-weight: bold; color: #dc2626;">
                            <?php echo number_format($grand_total, 0, ',', '.'); ?> VNĐ
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 18px;">
                <div>
                    <a href="cartView.php?clear=1" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');" style="padding: 7px 14px; background: #fee2e2; color: #dc2626; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold;">
                        🗑 Xóa toàn bộ giỏ
                    </a>
                    <button type="submit" name="btnUpdateCart" style="padding: 7px 16px; background: #e2e8f0; border: 1px solid #cbd5e1; border-radius: 4px; cursor: pointer; font-weight: bold; margin-left: 8px;">
                        🔄 Cập nhật số lượng
                    </button>
                </div>
                <div>
                    <button type="button" onclick="alert('Cảm ơn bạn đã đặt hàng! Chức năng hoàn tất đơn hàng đã ghi nhận thành công.'); window.location.href='index.php';" style="padding: 10px 24px; background: #16a34a; color: white; border: none; border-radius: 4px; font-weight: bold; font-size: 15px; cursor: pointer;">
                        TIẾN HÀNH ĐẶT HÀNG &rarr;
                    </button>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div style="padding: 40px; text-align: center;">
            <p style="font-size: 16px; color: #64748b; margin-bottom: 15px;">Giỏ hàng của bạn hiện đang trống!</p>
            <a href="productList.php" style="padding: 8px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
                Mua Sắm Ngay &rarr;
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
