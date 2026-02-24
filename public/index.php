<?php
session_start();

header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer-when-downgrade');

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/system/core/ExceptionHandler.php';
require BASE_PATH . '/system/core/Router.php';
require BASE_PATH . '/system/core/Controller.php';
require BASE_PATH . '/system/core/Response.php';
require BASE_PATH . '/system/core/Session.php';
require BASE_PATH . '/system/core/Helper.php';
require BASE_PATH . '/system/core/Config.php';
require BASE_PATH . '/system/db/Database.php';
require BASE_PATH . '/system/db/QueryBuilder.php';

spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/app/controller/',
        BASE_PATH . '/app/model/',
        BASE_PATH . '/system/middleware/',
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

ExceptionHandler::register();
Session::start();

require BASE_PATH . '/system/routes/web.php';
Router::run();
