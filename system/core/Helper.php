<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

function url($path = '')
{
    $base = Config::get('app', 'base_url');
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

/* ======================
   CSRF
====================== */

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="_csrf" value="' . csrf_token() . '">';
}

function csrf_verify()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            !isset($_POST['_csrf']) ||
            !isset($_SESSION['csrf_token']) ||
            $_POST['_csrf'] !== $_SESSION['csrf_token']
        ) {
            http_response_code(403);
            exit('CSRF validation failed');
        }
    }
}

