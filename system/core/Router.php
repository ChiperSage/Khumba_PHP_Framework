<?php
// system/core/Router.php

class Router
{
    protected static $routes = [];

    public static function get($uri, $action, $middleware = [])
    {
        self::add('GET', $uri, $action, $middleware);
    }

    public static function post($uri, $action, $middleware = [])
    {
        self::add('POST', $uri, $action, $middleware);
    }

    public static function any($uri, $action, $middleware = [])
    {
        self::add('ANY', $uri, $action, $middleware);
    }

    protected static function add($method, $uri, $action, $middleware)
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => trim($uri, '/'),
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public static function run()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        foreach (self::$routes as $route) {
            if ($route['method'] !== 'ANY' && $route['method'] !== $requestMethod) {
                continue;
            }

            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([^/]+)', $route['uri']);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches);

                self::runMiddleware($route['middleware']);

                return self::dispatch($route['action'], $matches);
            }
        }

        self::fallback($requestUri);
    }

    protected static function dispatch($action, $params = [])
    {
        if (is_callable($action)) {
            call_user_func_array($action, $params);
            return;
        }

        if (strpos($action, '@') !== false) {
            list($controller, $method) = explode('@', $action);

            $controllerFile = BASE_PATH . '/app/controller/' . $controller . '.php';

            if (!file_exists($controllerFile)) {
                return self::error404();
            }

            require_once $controllerFile;

            $obj = new $controller;

            if (!method_exists($obj, $method)) {
                return self::error404();
            }

            call_user_func_array([$obj, $method], $params);
            return;
        }

        return self::error404();
    }

    protected static function runMiddleware($middlewares)
    {
        foreach ($middlewares as $middleware) {
            $file = BASE_PATH . '/system/middleware/' . $middleware . '.php';

            if (!file_exists($file)) {
                continue;
            }

            require_once $file;

            $instance = new $middleware;

            if (method_exists($instance, 'handle')) {
                $instance->handle();
            }
        }
    }

    protected static function fallback($uri)
    {
        $segments = explode('/', $uri);

        $controller = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'HomeController';
        $method = isset($segments[1]) ? $segments[1] : 'index';

        $file = BASE_PATH . '/app/controller/' . $controller . '.php';

        if (!file_exists($file)) {
            return self::error404();
        }

        require_once $file;

        $obj = new $controller;

        if (!method_exists($obj, $method)) {
            return self::error404();
        }

        call_user_func([$obj, $method]);
    }

    protected static function error404()
    {
        http_response_code(404);
        require BASE_PATH . '/app/view/error/404.php';
        exit;
    }
}
