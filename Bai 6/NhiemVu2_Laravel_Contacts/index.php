<?php
/**
 * Contacts Hub Laravel - Application Entry Point
 * Học Viện Kỹ Thuật Mật Mã - Khoa An Toàn Thông Tin
 * Sinh viên: Phạm Tiến Đạt - AT200311
 */

require_once __DIR__ . '/bootstrap/app.php';
require_once __DIR__ . '/app/Http/Controllers/ContactController.php';

use App\Http\Controllers\ContactController;

LaravelKernel::init();

$route = $_GET['r'] ?? $_GET['url'] ?? '';
$controller = new ContactController();

if (empty($route) || $route === 'contacts' || $route === 'contacts/index') {
    $controller->index();
} elseif ($route === 'contacts/create') {
    $controller->create();
} elseif ($route === 'contacts/store') {
    $controller->store();
} elseif ($route === 'contacts/show') {
    $id = (int)($_GET['id'] ?? 0);
    $controller->show($id);
} elseif ($route === 'contacts/edit') {
    $id = (int)($_GET['id'] ?? 0);
    $controller->edit($id);
} elseif ($route === 'contacts/update') {
    $id = (int)($_GET['id'] ?? 0);
    $controller->update($id);
} elseif ($route === 'contacts/destroy') {
    $controller->destroy();
} elseif ($route === 'contacts/export') {
    $controller->exportCsv();
} else {
    $controller->index();
}
