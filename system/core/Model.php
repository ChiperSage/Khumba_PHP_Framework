<?php
class Model
{
    protected static $table;
    protected static $primaryKey = 'id';

    /**
     * Get a fresh QueryBuilder instance for this model's table.
     */
    public static function query()
    {
        return Database::table(static::$table);
    }

    /**
     * Find a single record by primary key.
     * Usage: User::find(1)
     */
    public static function find($id)
    {
        return static::query()
            ->where(static::$primaryKey, $id)
            ->first();
    }

    /**
     * Find or throw a 404 if not found.
     * Usage: User::findOrFail($id)
     */
    public static function findOrFail($id)
    {
        $record = static::find($id);

        if (!$record) {
            http_response_code(404);
            $view404 = BASE_PATH . '/app/view/error/404.php';
            file_exists($view404) ? require $view404 : die('404 Not Found');
            exit;
        }

        return $record;
    }

    /**
     * Shortcut for where() on the QueryBuilder.
     */
    public static function where($column, $value, $operator = '=')
    {
        return static::query()->where($column, $value, $operator);
    }

    /**
     * Get all records.
     */
    public static function all()
    {
        return static::query()->get();
    }

    /**
     * Insert a new record.
     * Usage: User::create(['name' => 'John', 'email' => 'john@example.com'])
     */
    public static function create($data)
    {
        return static::query()->insert($data);
    }

    /**
     * Count all records (or with condition).
     * Usage: User::count()
     */
    public static function count()
    {
        return static::query()->count();
    }
}
