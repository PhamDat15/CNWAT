<?php
/**
 * ProductController: Danh mục, Chi tiết, AJAX Live Search, AJAX Filter
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController extends Controller {
    private Product $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function index(): void {
        $page = max(1, (int)$this->get('page', 1));
        $limit = 9;
        $offset = ($page - 1) * $limit;

        $filters = [
            'brand' => $this->get('brand', ''),
            'min_price' => $this->get('min_price', ''),
            'max_price' => $this->get('max_price', ''),
            'search' => $this->get('search', '')
        ];

        $products = $this->productModel->getAll($limit, $offset, $filters);
        $totalItems = $this->productModel->countFiltered($filters);
        $totalPages = ceil($totalItems / $limit);

        $this->render('product/index', [
            'pageTitle' => 'Danh Mục Sản Phẩm Laptop',
            'products' => $products,
            'filters' => $filters,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems
        ]);
    }

    public function detail(): void {
        $id = (int)$this->get('id', 0);
        if ($id <= 0) {
            $this->redirect('index.php?r=product/index');
        }

        $product = $this->productModel->getById($id);
        if (!$product) {
            $this->setFlash('error', 'Sản phẩm không tồn tại!');
            $this->redirect('index.php?r=product/index');
        }

        $relatedProducts = $this->productModel->getRelated($product['brand'], $id, 4);

        $this->render('product/detail', [
            'pageTitle' => $product['name'] . ' - Chi Tiết Cấu Hình',
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    /**
     * AJAX Live Search Endpoint
     */
    public function ajaxSearch(): void {
        $keyword = trim($this->get('q', ''));
        if (strlen($keyword) < 2) {
            $this->json([]);
        }

        $results = $this->productModel->searchLive($keyword, 6);
        $this->json($results);
    }

    /**
     * AJAX Filter Products Endpoint
     */
    public function ajaxFilter(): void {
        $brand = $this->get('brand', '');
        $minPrice = $this->get('min_price', '');
        $maxPrice = $this->get('max_price', '');
        $search = $this->get('search', '');

        $filters = [
            'brand' => $brand,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'search' => $search
        ];

        $products = $this->productModel->getAll(12, 0, $filters);
        $total = $this->productModel->countFiltered($filters);

        $this->json([
            'success' => true,
            'count' => $total,
            'products' => $products
        ]);
    }
}
