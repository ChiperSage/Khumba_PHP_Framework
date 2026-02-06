<?php
// system/core/Env.php

class Env
{
    protected static $data = [];

    public static function load($path = '.env')
    {
        if (!file_exists($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            $parts = explode('=', $line, 2);

            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);

                self::$data[$key] = $value;
                putenv("$key=$value");
            }
        }
    }

    public static function get($key, $default = null)
    {
        if (isset(self::$data[$key])) {
            return self::$data[$key];
        }

        $env = getenv($key);
        return $env !== false ? $env : $default;
    }
}
