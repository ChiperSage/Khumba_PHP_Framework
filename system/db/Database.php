// system/db/Database.php
class Database
{
    protected static $pdo;

    public static function connect()
    {
        if (!self::$pdo) {
            $c = Config::get('database');
            self::$pdo = new PDO(
                "{$c['driver']}:host={$c['host']};dbname={$c['database']}",
                $c['username'],
                $c['password']
            );
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }
}
