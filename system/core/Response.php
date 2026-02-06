<?php
// system/core/Response.php

class Response
{
    public static function json($data = [], $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function redirect($url, $status = 302)
    {
        http_response_code($status);
        header('Location: ' . $url);
        exit;
    }

    public static function view($view, $data = [])
    {
        View::render($view, $data);
        exit;
    }

    public static function text($text, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: text/plain');
        echo $text;
        exit;
    }
}
