<?php
/**
 * AdminController: Phân hệ Quản trị viên
 * Bảo vệ nghiêm ngặt bằng Role-based Access Control (RBAC), CSRF Token, Rich Text Editor, Datetime Picker
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Order.php';

class AdminController extends Controller {
    private Product $productModel;
    private User $userModel;
    private Order $orderModel;

    public function __construct() {
        $this->requireAdmin();
        $this->productModel = new Product();
        $this->userModel = new User();
        $this->orderModel = new Order();
    }

    public function dashboard(): void {
        $stats = [
            'total_products' => $this->productModel->countFiltered([]),
            'total_users' => $this->userModel->countUsers(),
            'total_orders' => $this->orderModel->countOrders(),
            'total_revenue' => $this->orderModel->getTotalRevenue()
        ];

        $recentOrders = array_slice($this->orderModel->getAllOrders(), 0, 5);
        $recentProducts = $this->productModel->getAll(5, 0, []);

        $this->render('admin/dashboard', [
            'pageTitle' => 'Admin Dashboard - Tổng Quan Hệ Thống',
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'recentProducts' => $recentProducts
        ], 'admin');
    }

    public function products(): void {
        $products = $this->productModel->getAll(100, 0, []);
        $this->render('admin/products', [
            'pageTitle' => 'Quản Lý Sản Phẩm Laptop',
            'products' => $products
        ], 'admin');
    }

    public function productAdd(): void {
        $errors = [];

        if ($this->isPost()) {
            $this->validateCsrfOrAbort();

            $name = trim($this->post('name', ''));
            $brand = trim($this->post('brand', ''));
            $price = (float)$this->post('price', 0);
            $oldPrice = !empty($_POST['old_price']) ? (float)$this->post('old_price') : null;
            $quantity = (int)$this->post('quantity', 10);
            $shortDesc = trim($this->post('short_desc', ''));
            // Rich text HTML description (giữ các thẻ an toàn)
            $description = $this->post('description', '', true);
            $specsCpu = trim($this->post('specs_cpu', ''));
            $specsRam = trim($this->post('specs_ram', ''));
            $specsStorage = trim($this->post('specs_storage', ''));
            $specsScreen = trim($this->post('specs_screen', ''));
            $createdAt = trim($this->post('created_at', ''));

            if (empty($name)) $errors[] = 'Tên sản phẩm không được để trống.';
            if (empty($brand)) $errors[] = 'Hãng sản xuất không được để trống.';
            if ($price <= 0) $errors[] = 'Giá bán phải lớn hơn 0.';

            // Xử lý upload ảnh an toàn
            $imageName = 'dell_vostro.jpg'; // Ảnh mặc định
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $targetDir = __DIR__ . '/../uploads/';
                $uploadResult = Security::validateAndUploadImage($_FILES['image'], $targetDir);
                if ($uploadResult['success']) {
                    $imageName = $uploadResult['fileName'];
                } else {
                    $errors[] = $uploadResult['error'];
                }
            }

            if (empty($errors)) {
                $this->productModel->create([
                    'name' => $name,
                    'brand' => $brand,
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'quantity' => $quantity,
                    'image' => $imageName,
                    'short_desc' => $shortDesc,
                    'description' => $description,
                    'specs_cpu' => $specsCpu,
                    'specs_ram' => $specsRam,
                    'specs_storage' => $specsStorage,
                    'specs_screen' => $specsScreen,
                    'created_at' => !empty($createdAt) ? $createdAt : date('Y-m-d H:i:s')
                ]);

                $this->setFlash('success', 'Đã thêm laptop mới thành công!');
                $this->redirect('index.php?r=admin/products');
            }
        }

        $this->render('admin/product_form', [
            'pageTitle' => 'Thêm Mới Laptop',
            'product' => null,
            'errors' => $errors
        ], 'admin');
    }

    public function productEdit(): void {
        $id = (int)$this->get('id', 0);
        $product = $this->productModel->getById($id);

        if (!$product) {
            $this->setFlash('error', 'Sản phẩm không tồn tại!');
            $this->redirect('index.php?r=admin/products');
        }

        $errors = [];

        if ($this->isPost()) {
            $this->validateCsrfOrAbort();

            $name = trim($this->post('name', ''));
            $brand = trim($this->post('brand', ''));
            $price = (float)$this->post('price', 0);
            $oldPrice = !empty($_POST['old_price']) ? (float)$this->post('old_price') : null;
            $quantity = (int)$this->post('quantity', 10);
            $shortDesc = trim($this->post('short_desc', ''));
            $description = $this->post('description', '', true);
            $specsCpu = trim($this->post('specs_cpu', ''));
            $specsRam = trim($this->post('specs_ram', ''));
            $specsStorage = trim($this->post('specs_storage', ''));
            $specsScreen = trim($this->post('specs_screen', ''));

            if (empty($name)) $errors[] = 'Tên sản phẩm không được để trống.';
            if ($price <= 0) $errors[] = 'Giá bán phải lớn hơn 0.';

            $imageName = $product['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $targetDir = __DIR__ . '/../uploads/';
                $uploadResult = Security::validateAndUploadImage($_FILES['image'], $targetDir);
                if ($uploadResult['success']) {
                    $imageName = $uploadResult['fileName'];
                } else {
                    $errors[] = $uploadResult['error'];
                }
            }

            if (empty($errors)) {
                $this->productModel->update($id, [
                    'name' => $name,
                    'brand' => $brand,
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'quantity' => $quantity,
                    'image' => $imageName,
                    'short_desc' => $shortDesc,
                    'description' => $description,
                    'specs_cpu' => $specsCpu,
                    'specs_ram' => $specsRam,
                    'specs_storage' => $specsStorage,
                    'specs_screen' => $specsScreen
                ]);

                $this->setFlash('success', 'Cập nhật thông tin laptop thành công!');
                $this->redirect('index.php?r=admin/products');
            }
        }

        $this->render('admin/product_form', [
            'pageTitle' => 'Chỉnh Sửa Laptop: ' . Security::escape($product['name']),
            'product' => $product,
            'errors' => $errors
        ], 'admin');
    }

    public function productDelete(): void {
        $this->validateCsrfOrAbort();
        $id = (int)$this->post('id', 0);
        if ($id > 0) {
            $this->productModel->delete($id);
            $this->setFlash('success', 'Đã xóa sản phẩm thành công!');
        }
        $this->redirect('index.php?r=admin/products');
    }

    public function users(): void {
        $users = $this->userModel->getAll();
        $this->render('admin/users', [
            'pageTitle' => 'Quản Lý Người Dùng & Phân Quyền',
            'users' => $users
        ], 'admin');
    }

    public function userEdit(): void {
        $id = (int)$this->get('id', 0);
        $user = $this->userModel->findById($id);
        if (!$user) {
            $this->setFlash('error', 'Người dùng không tồn tại!');
            $this->redirect('index.php?r=admin/users');
        }

        $error = null;
        if ($this->isPost()) {
            $this->validateCsrfOrAbort();
            $fullname = trim($this->post('fullname', ''));
            $email = trim($this->post('email', ''));
            $role = in_array($this->post('role'), ['admin', 'customer']) ? $this->post('role') : 'customer';

            $this->userModel->update($id, [
                'fullname' => $fullname,
                'email' => $email,
                'role' => $role
            ]);

            $this->setFlash('success', 'Đã cập nhật phân quyền người dùng!');
            $this->redirect('index.php?r=admin/users');
        }

        $this->render('admin/user_form', [
            'pageTitle' => 'Chỉnh Sửa Tài Khoản: ' . Security::escape($user['username']),
            'user' => $user,
            'error' => $error
        ], 'admin');
    }

    public function userDelete(): void {
        $this->validateCsrfOrAbort();
        $id = (int)$this->post('id', 0);
        $currentUser = Security::getUser();

        if ($id === (int)$currentUser['id']) {
            $this->setFlash('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        } elseif ($id > 0) {
            $this->userModel->delete($id);
            $this->setFlash('success', 'Đã xóa người dùng thành công!');
        }
        $this->redirect('index.php?r=admin/users');
    }

    public function orders(): void {
        $orders = $this->orderModel->getAllOrders();
        $this->render('admin/orders', [
            'pageTitle' => 'Quản Lý Đơn Hàng Khách Hàng',
            'orders' => $orders
        ], 'admin');
    }

    public function orderStatus(): void {
        $this->validateCsrfOrAbort();
        $id = (int)$this->post('id', 0);
        $status = $this->post('status', 'pending');
        $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];

        if (in_array($status, $validStatuses) && $id > 0) {
            $this->orderModel->updateStatus($id, $status);
            $this->setFlash('success', "Đã cập nhật trạng thái đơn hàng #{$id} thành công!");
        }
        $this->redirect('index.php?r=admin/orders');
    }
}
