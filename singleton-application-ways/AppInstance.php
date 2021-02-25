<?php
/**
 * Приложение имеет единственный инстанс.
 */
namespace AppInstance;

class BaseApp
{
    protected $name;
    protected static $instance;
    public static function instance(): BaseApp
    {
        if (empty(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }
    public static function set(string $name, $value): BaseApp
    {
        static::instance()->$name = &$value;
        return static::$instance;
    }
    public static function get(string $name)
    {
        return static::instance()->$name;
    }
    public function __set(string $name, $value)
    {
        return static::set($name, $value);
    }
    public function __get(string $name)
    {
        return static::get($name);
    }
    public static function unsetInstance()
    {
        static::$instance = null;
    }
}

class App0 extends BaseApp
{}
class App1 extends BaseApp
{
    // public $name = 'lol'; // Вот тут задаём свойство открыто!
    // protected static $instance; // Вот тут задаём персональный инстанс!
}
class App2 extends BaseApp
{
    // public $name = 'lol'; // Вот тут задаём свойство открыто!
    protected static $instance; // Вот тут задаём персональный инстанс!
}
class App3 extends BaseApp
{
    public $name = 'lol'; // Вот тут задаём свойство открыто!
    protected static $instance; // Вот тут задаём персональный инстанс!
}
class App4 extends BaseApp
{
    public $name = 'lol'; // Вот тут задаём свойство открыто!
    // protected static $instance; // Вот тут задаём персональный инстанс!
}
