<?php
class ExceptionHandler {
    public static function register() {
        set_exception_handler(function($e) {
            $env = getenv('APP_ENV') ?: 'production';
            http_response_code(500);

            if ($env === 'development') {
                echo "<h1>Uncaught Exception</h1>";
                echo "<pre>" . htmlspecialchars($e) . "</pre>";
            } else {
                error_log((string)$e);
                echo "Internal Server Error";
            }
        });
    }
}
