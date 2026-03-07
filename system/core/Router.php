<?php
class Router {
    protected static $routes    = [];
    protected static $csrfSkip  = [];

    public static function get($uri, $action) {
        self::$routes['GET'][$uri] = $action;
    }

    public static function post($uri, $action) {
        self::$routes['POST'][$uri] = $action;
    }

    /**
     * Mark a POST route as CSRF-exempt.
     * Usage: Router::skipCsrf('api/webhook');
     */
    public static function skipCsrf($uri) {
        self::$csrfSkip[] = trim($uri, '/');
    }

    public static function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Auto CSRF check for every POST unless explicitly skipped
        if ($method === 'POST' && !in_array($uri, self::$csrfSkip)) {
            SecurityHelper::verify_csrf();
        }

        // Direct match
        if (isset(self::$routes[$method][$uri])) {
            return self::dispatch(self::$routes[$method][$uri], []);
        }

        // Dynamic segment match e.g. user/{id}
        foreach (self::$routes[$method] ?? [] as $route => $action) {
            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                array_shift($matches);
                return self::dispatch($action, $matches);
            }
        }

        http_response_code(404);
        $view404 = BASE_PATH . '/app/view/error/404.php';
        file_exists($view404) ? require $view404 : echo '404 Not Found';
    }

    protected static function dispatch($action, $params = []) {
        list($controller, $method) = explode('@', $action);
        $instance = new $controller;
        return call_user_func_array([$instance, $method], $params);
    }
}
