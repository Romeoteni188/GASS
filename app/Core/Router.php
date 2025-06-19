<?php
namespace App\Core;

class Router {
    private $routes = [];

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $action = $this->routes[$method][$uri] ?? null;

        if ($action) {
            [$controllerName, $method] = explode('@', $action);
            $controllerClass = "App\\Controllers\\$controllerName";
            $controller = new $controllerClass();
            call_user_func([$controller, $method]);
        } else {
            http_response_code(404);
            echo "404 - Not Found";
        }
    }
}

