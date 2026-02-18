<?php
class Config {
    public static function get($key) {
        $config = require BASE_PATH . '/config/app.php';
        return $config[$key] ?? null;
    }
}
