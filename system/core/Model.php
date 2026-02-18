<?php
class Model
{
    protected static $table;

    public static function query()
    {
        return Database::table(static::$table);
    }

    public static function where($column, $value)
    {
        return static::query()->where($column, $value);
    }

    public static function all()
    {
        return static::query()->get();
    }
}
