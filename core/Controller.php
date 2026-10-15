<?php
class Controller {
    public function __construct() {
        if (function_exists('startStudentSession')) {
            startStudentSession();
        } elseif (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    protected function validateCsrf() {
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (empty($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => 'CSRF token validation failed.']);
            exit;
        }
    }    public function view($view, $data = []) {
        extract($data);
        $file = null;
        if (file_exists("app/Views/$view.php")) {
            $file = "app/Views/$view.php";
        } elseif (file_exists("app/Views/$view.html")) {
            $file = "app/Views/$view.html";
        } else {
            echo "View does not exist: $view";
            return;
        }

        ob_start();
        require $file;
        $content = ob_get_clean();

        // If the view already contains an HTML skeleton, output it directly (backwards compatibility)
        if (stripos($content, '<html') !== false) {
            echo $content;
        } else {
            // Otherwise, inject the view content into the layout
            require "app/Views/layout.php";
        }
    }

    public function model($model) {
        return new $model();
    }
}
