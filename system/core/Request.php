<?php

class Request
{
    public static function get($key = null)
    {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    public static function post($key = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
