<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\MedicineController;

// Simple router
$uri = $_GET['uri'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

$controller = new MedicineController();

if ($uri === 'medicines' && $method === 'GET') {
    $controller->getAll();
} elseif (preg_match('#medicines/(\d+)#', $uri, $matches) && $method === 'GET') {
    $controller->getById($matches[1]);
} elseif ($uri === 'medicines' && $method === 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);
    $controller->create($postData);
} elseif (preg_match('#medicines/(\d+)#', $uri, $matches) && $method === 'DELETE') {
    $controller->delete($matches[1]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}
