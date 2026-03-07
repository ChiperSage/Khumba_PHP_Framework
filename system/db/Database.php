<?php
class Database
{
    protected static $pdo;

    public static function connect()
    {
        if (!self::$pdo) {
            $config = require BASE_PATH . '/config/database.php';

            $dsn = $config['driver']
                . ":host="    . $config['host']
                . ";port="    . $config['port']
                . ";dbname="  . $config['database']
                . ";charset=" . $config['charset'];

            self::$pdo = new PDO($dsn, $config['username'], $config['password']);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        return self::$pdo;
    }

    public static function table($table)
    {
        return new QueryBuilder(self::connect(), $table);
    }
}
