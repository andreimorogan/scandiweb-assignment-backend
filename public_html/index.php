<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Scandiweb\Core\Router;
use Scandiweb\Controllers\ProductController;


header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

$router = new Router();
$productController = new ProductController();

$router->addRoute('GET', '/', function () use ($productController) {
    echo json_encode($productController->read());
});

$router->addRoute('POST', '/', function () use ($productController) {
    echo json_encode($productController->create());
});

$router->addRoute('POST', '/delete', function () use ($productController) {
    echo json_encode($productController->delete()); // Preflight requests are not available on 000webhost
});

$router->dispatch();
