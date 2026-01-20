<?php

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
