<?php

class ExceptionHandler
{
    public static function register()
    {
        set_exception_handler([__CLASS__, 'handle']);
    }

    public static function handle($e)
    {
        error_log($e->getMessage());

        if (Config::get('app', 'env') === 'development') {
            echo '<pre>' . $e . '</pre>';
        } else {
            require BASE_PATH . '/app/view/error/500.php';
        }
    }
}
