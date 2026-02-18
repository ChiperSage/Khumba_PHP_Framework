<?php
class ExceptionHandler {
    public static function register() {
        set_exception_handler(function($e) {
            http_response_code(500);
            echo "Internal Server Error";
        });
    }
}
