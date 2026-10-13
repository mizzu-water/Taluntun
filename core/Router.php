<?php
class Router {
    protected $routes = [];

    public function add($route, $action) {
        $this->routes[$route] = $action;
    }

    public function dispatch($url) {
        // Strip query string from the URL before matching
        if (strpos($url, '?') !== false) {
            $url = substr($url, 0, strpos($url, '?'));
        }

        // Clean up the URL
        $url = '/' . trim($url, '/');

        // Remove .html if it exists so old links still work gracefully
        if (str_ends_with($url, '.html')) {
            $url = substr($url, 0, -5);
        }

        // Map /index and /landing to /
        if ($url === '/index' || $url === '/landing' || $url === '/home') {
            $url = '/';
        }

        if (array_key_exists($url, $this->routes)) {
            $action = $this->routes[$url];
            list($controller, $method) = explode('@', $action);

            $controllerInstance = new $controller();
            $controllerInstance->$method();
        } else {
            http_response_code(404);
            echo "404 Not Found: " . htmlspecialchars($url);
        }
    }
}
