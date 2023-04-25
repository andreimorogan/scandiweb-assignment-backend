<?php

require_once(__DIR__ . '/../src/Autoload/Autoloader.php');

use Scandiweb\Autoload\Autoloader;
use Scandiweb\Core\Router;
use Scandiweb\Controllers\ProductController;

Autoloader::register();
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
