<?php
// public/index.php
ExceptionHandler::register();

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/system/core/Router.php';
require BASE_PATH . '/system/core/Controller.php';
require BASE_PATH . '/system/core/Helper.php';

csrf_verify();

// simple autoload app
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

// run router
Router::run();
