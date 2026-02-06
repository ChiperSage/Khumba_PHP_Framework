<?php
// system/core/Session.php

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public static function forget($key)
    {
        unset($_SESSION[$key]);
    }

    public static function flash($key, $value = null)
    {
        if ($value === null) {
            $data = self::get($key);
            self::forget($key);
            return $data;
        }

        self::set($key, $value);
    }

    public static function destroy()
    {
        session_destroy();
    }
}
