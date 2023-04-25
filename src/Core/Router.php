<?php

namespace Scandiweb\Core;

class Router
{
    private $routes = [];
    private $allowedOrigins = ['http://localhost:3000'];

    public function addRoute($method, $path, $handler)
    {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            if (is_callable($handler)) {
                if (in_array($origin, $this->allowedOrigins)) {
                    header('Access-Control-Allow-Origin: ' . $origin);
                    header('Access-Control-Allow-Methods: GET, POST');
                    header('Content-Type: application/json');
                    echo call_user_func($handler);
                } else {
                    http_response_code(403);
                    echo ('403 - Forbidden.');
                }
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Handler is not callable']);
            }
        } elseif ($path === '/') {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not Found']);
        }
    }
}
