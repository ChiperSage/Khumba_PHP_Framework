<?php
class SecurityHelper {

    public static function csrf_token() {
        if (!isset($_SESSION['_csrf_token'])) {
            try {
                $_SESSION['_csrf_token'] = bin2hex(random_bytes(16));
            } catch (Exception $e) {
                $_SESSION['_csrf_token'] = sha1(uniqid('', true));
            }
        }
        return $_SESSION['_csrf_token'];
    }

    public static function csrf_field() {
        $token = self::csrf_token();
        return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function verify_csrf() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $posted = $_POST['_csrf_token'] ?? '';
            if (!$posted || $posted !== ($_SESSION['_csrf_token'] ?? '')) {
                http_response_code(403);
                echo "Forbidden - Invalid CSRF Token";
                exit;
            }
        }
    }

    public static function e($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
