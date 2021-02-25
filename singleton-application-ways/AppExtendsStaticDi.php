<?php
/**
 * Приложение наследует статический Di контейнер.
 */
namespace AppExtendsStaticDi;

class StaticContainer
{
    protected static $instance;

    public static function instance(): StaticContainer
    {
        if (empty(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public static function set(string $name, $value): StaticContainer
    {
        $instance = static::instance();
        if ($value instanceof \Closure) {
            $value = $value->bindTo($instance);
        }
        $instance->$name = &$value;
        return $instance;
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

class BaseApp extends StaticContainer
{
    protected $name;
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
