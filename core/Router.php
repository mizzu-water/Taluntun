<?php
class Router {
    protected $routes = [];
    protected $protectedRoutes = [];

    public function add($route, $action, $protected = false) {
        $this->routes[$route] = $action;
        if ($protected) $this->protectedRoutes[$route] = true;
    }

    public function dispatch($url) {
        $requestedTarget = $url;
        if (strpos($requestedTarget, '?') === false) {
            $query = $_GET;
            unset($query['url']);
            if ($query) $requestedTarget .= '?' . http_build_query($query);
        }
        if (strpos($url, '?') !== false) $url = substr($url, 0, strpos($url, '?'));
        $url = '/' . trim($url, '/');
        if (str_ends_with($url, '.html')) $url = substr($url, 0, -5);
        if ($url === '/index' || $url === '/landing' || $url === '/home') $url = '/';

        if (!array_key_exists($url, $this->routes)) {
            http_response_code(404);
            echo '404 Not Found: ' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            return;
        }

        if (isset($this->protectedRoutes[$url])) {
            require_once __DIR__ . '/../auth/config.php';
            header('Cache-Control: no-store, private, max-age=0');
            header('Pragma: no-cache');
            $guardReturn = $requestedTarget;
            if ($url === '/api/get_course_questions' && isset($_GET['degree_id']) && ctype_digit((string)$_GET['degree_id'])) {
                $guardReturn = 'course-quiz?degree_id=' . (string)(int)$_GET['degree_id'];
            } elseif ($url === '/api/authorize_assessment' && isset($_GET['return_to'])) {
                $guardReturn = (string)$_GET['return_to'];
            }
            requireLogin($guardReturn, strpos($url, '/api/') === 0);
        }

        list($controller, $method) = explode('@', $this->routes[$url]);
        $controllerInstance = new $controller();
        $controllerInstance->$method();
    }
}