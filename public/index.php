<?php
// public/index.php

Env::load(BASE_PATH . '/.env');
Session::start();


define('BASE_PATH', dirname(__DIR__));

/*
 |-------------------------------------------------
 | Security Headers
 |-------------------------------------------------
 */
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');

/*
 |-------------------------------------------------
 | Session
 |-------------------------------------------------
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
 |-------------------------------------------------
 | Core Load (WAJIB URUTAN INI)
 |-------------------------------------------------
 */
require BASE_PATH . '/system/core/ExceptionHandler.php';
require BASE_PATH . '/system/core/Router.php';
require BASE_PATH . '/system/core/Controller.php';
require BASE_PATH . '/system/core/Helper.php';

/*
 |-------------------------------------------------
 | Register Exception
 |-------------------------------------------------
 */
ExceptionHandler::register();

/*
 |-------------------------------------------------
 | CSRF Verify (POST only)
 |-------------------------------------------------
 */
csrf_verify();

/*
 |-------------------------------------------------
 | Autoload App & Core
 |-------------------------------------------------
 */
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/app/controller/',
        BASE_PATH . '/app/model/',
        BASE_PATH . '/system/core/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

/*
 |-------------------------------------------------
 | Run Application
 |-------------------------------------------------
 */
Router::run();
