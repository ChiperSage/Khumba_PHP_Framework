<?php

class Router
{
    public static function run()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $segments = $uri ? explode('/', $uri) : [];

        $controller = isset($segments[0])
            ? ucfirst($segments[0]) . 'Controller'
            : 'HomeController';

        $method = $segments[1] ?? 'index';
        $params = array_slice($segments, 2);

        if (!class_exists($controller)) {
            self::error404('Controller not found');
        }

        $object = new $controller();

        if (!method_exists($object, $method)) {
            self::error404('Method not found');
        }

        call_user_func_array([$object, $method], $params);
    }

    protected static function error404()
    {
        http_response_code(404);
        require BASE_PATH . '/app/view/error/404.php';
        exit;
    }
}


