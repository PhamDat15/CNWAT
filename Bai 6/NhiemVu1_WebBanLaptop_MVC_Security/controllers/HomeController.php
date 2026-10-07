<?php
/**
 * HomeController: Điều phối hiển thị trang chủ website Laptop MVC
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';

class HomeController extends Controller {
    private Product $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function index(): void {
        // Lấy 2 sản phẩm mới nhất mỗi hãng theo đúng đặc tả Lab
        $brandProducts = $this->productModel->getLatestByBrands();
        $featuredProducts = $this->productModel->getFeatured(4);

        $this->render('home/index', [
            'pageTitle' => 'Trang Chủ - Thế Giới Laptop Chính Hãng & An Toàn',
            'brandProducts' => $brandProducts,
            'featuredProducts' => $featuredProducts
        ]);
    }
}
