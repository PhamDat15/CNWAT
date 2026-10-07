<?php
/**
 * CartController: Quản lý Giỏ hàng (Session Shopping Cart) và Đặt hàng
 * Tích hợp AJAX thêm giỏ hàng, cập nhật số lượng, CSRF Token và Transaction CSDL
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';

class CartController extends Controller {
    private Product $productModel;
    private Order $orderModel;

    public function __construct() {
        Security::startSecureSession();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }

    public function index(): void {
        $cart = $_SESSION['cart'];
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $this->render('cart/index', [
            'pageTitle' => 'Giỏ Hàng Của Bạn',
            'cart' => $cart,
            'totalAmount' => $totalAmount
        ]);
    }

    /**
     * AJAX Thêm sản phẩm vào giỏ hàng
     */
    public function add(): void {
        $id = (int)$this->post('id', 0);
        $qty = max(1, (int)$this->post('quantity', 1));

        $product = $this->productModel->getById($id);
        if (!$product) {
            $this->json(['success' => false, 'message' => 'Sản phẩm không tồn tại!'], 404);
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $qty;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'brand' => $product['brand'],
                'price' => (float)$product['price'],
                'image' => $product['image'],
                'quantity' => $qty
            ];
        }

        $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
        $totalAmount = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $this->json([
            'success' => true,
            'message' => 'Đã thêm "' . Security::escape($product['name']) . '" vào giỏ hàng!',
            'cartCount' => $cartCount,
            'totalAmount' => number_format($totalAmount, 0, ',', '.') . ' đ'
        ]);
    }

    /**
     * AJAX Cập nhật số lượng
     */
    public function update(): void {
        $id = (int)$this->post('id', 0);
        $qty = (int)$this->post('quantity', 1);

        if ($qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } elseif (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
        }

        $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
        $itemSubtotal = isset($_SESSION['cart'][$id]) 
            ? ($_SESSION['cart'][$id]['price'] * $_SESSION['cart'][$id]['quantity']) 
            : 0;

        $totalAmount = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $this->json([
            'success' => true,
            'cartCount' => $cartCount,
            'itemSubtotal' => number_format($itemSubtotal, 0, ',', '.') . ' đ',
            'totalAmount' => number_format($totalAmount, 0, ',', '.') . ' đ'
        ]);
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove(): void {
        $id = (int)$this->get('id', 0);
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            $this->setFlash('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        }
        $this->redirect('index.php?r=cart/index');
    }

    /**
     * Làm rỗng toàn bộ giỏ hàng
     */
    public function clear(): void {
        $_SESSION['cart'] = [];
        $this->setFlash('success', 'Đã xóa sạch giỏ hàng.');
        $this->redirect('index.php?r=cart/index');
    }

    /**
     * Trang thanh toán đơn hàng & Xử lý đặt hàng
     */
    public function checkout(): void {
        $cart = $_SESSION['cart'];
        if (empty($cart)) {
            $this->setFlash('warning', 'Giỏ hàng của bạn đang trống.');
            $this->redirect('index.php?r=product/index');
        }

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $user = Security::getUser();

        if ($this->isPost()) {
            $this->validateCsrfOrAbort();

            $name = trim($this->post('customer_name', ''));
            $phone = trim($this->post('customer_phone', ''));
            $address = trim($this->post('customer_address', ''));
            $notes = trim($this->post('customer_notes', ''));

            $errors = [];
            if (empty($name) || mb_strlen($name) < 2) {
                $errors[] = 'Họ và tên người nhận không được để trống.';
            }
            if (empty($phone) || !preg_match('/^(0[3|5|7|8|9])[0-9]{8}$/', $phone)) {
                $errors[] = 'Số điện thoại không hợp lệ (Phải là 10 chữ số đầu số Việt Nam).';
            }
            if (empty($address) || mb_strlen($address) < 5) {
                $errors[] = 'Địa chỉ giao hàng quá ngắn hoặc để trống.';
            }

            if (!empty($errors)) {
                $this->render('cart/checkout', [
                    'pageTitle' => 'Thanh Toán Đơn Hàng',
                    'cart' => $cart,
                    'totalAmount' => $totalAmount,
                    'errors' => $errors,
                    'formData' => ['name' => $name, 'phone' => $phone, 'address' => $address, 'notes' => $notes]
                ]);
                return;
            }

            $userId = $user ? $user['id'] : null;
            $orderId = $this->orderModel->createOrder($userId, $name, $phone, $address, $notes, $cart, $totalAmount);

            // Xóa sạch giỏ hàng sau khi đặt thành công
            $_SESSION['cart'] = [];
            $this->setFlash('success', "Đặt hàng thành công! Mã đơn hàng của bạn là #{$orderId}. Nhân viên sẽ liên hệ sớm nhất!");
            $this->redirect('index.php?r=home/index');
        }

        $this->render('cart/checkout', [
            'pageTitle' => 'Thanh Toán Đơn Hàng',
            'cart' => $cart,
            'totalAmount' => $totalAmount,
            'errors' => [],
            'formData' => [
                'name' => $user['fullname'] ?? '',
                'phone' => '',
                'address' => '',
                'notes' => ''
            ]
        ]);
    }
}
