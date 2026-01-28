<?php
// system/core/Config.php

class Config
{
    protected static $data = [];

    /**
     * Load config file once
     */
    public static function load($name)
    {
        if (isset(self::$data[$name])) {
            return;
        }

        $file = BASE_PATH . '/config/' . $name . '.php';

        if (!file_exists($file)) {
            self::$data[$name] = [];
            return;
        }

        self::$data[$name] = require $file;
    }

    /**
     * Get config value
     * Config::get('app', 'name')
     */
    public static function get($name, $key = null, $default = null)
    {
        if (!isset(self::$data[$name])) {
            self::load($name);
        }

        if ($key === null) {
            return self::$data[$name];
        }

        return isset(self::$data[$name][$key])
            ? self::$data[$name][$key]
            : $default;
    }
}
