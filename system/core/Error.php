// system/core/Error.php
class ErrorHandler
{
    public static function register()
    {
        set_error_handler([__CLASS__, 'handle']);
    }

    public static function handle($errno, $errstr, $file, $line)
    {
        error_log("[$errno] $errstr in $file:$line");
        if (Config::get('app', 'env') === 'development') {
            echo "<pre>$errstr\n$file:$line</pre>";
        } else {
            echo 'Internal Server Error';
        }
    }
}
