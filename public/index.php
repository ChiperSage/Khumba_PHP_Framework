<?php
define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/system/core/ExceptionHandler.php';
require BASE_PATH . '/system/core/Router.php';
require BASE_PATH . '/system/core/Controller.php';
require BASE_PATH . '/system/core/Response.php';
require BASE_PATH . '/system/core/Session.php';
require BASE_PATH . '/system/core/Helper.php';
require BASE_PATH . '/system/core/Config.php';

spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/app/controller/',
        BASE_PATH . '/app/model/',
        BASE_PATH . '/system/core/',
        BASE_PATH . '/system/db/',
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
