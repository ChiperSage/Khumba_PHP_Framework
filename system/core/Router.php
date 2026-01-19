<?php
// system/core/Router.php

class Router
{
    public static function run()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if ($uri === '') {
            $controller = 'HomeController';
            $method = 'index';
        } else {
            $parts = explode('/', $uri);
            $controller = ucfirst($parts[0]) . 'Controller';
            $method = $parts[1] ?? 'index';
        }

        if (!class_exists($controller)) {
            http_response_code(404);
            echo 'Controller not found';
            return;
        }

        $obj = new $controller();

        if (!method_exists($obj, $method)) {
            http_response_code(404);
            echo 'Method not found';
            return;
        }

        $obj->$method();
    }
}
