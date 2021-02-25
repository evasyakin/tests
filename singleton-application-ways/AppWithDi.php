<?php
/**
 * Приложения с привязанным через статику Di-контейнером.
 */
namespace AppWithDi;

// Di-контейнер
class Container
{
    public function set(string $name, $value)
    {
        $this->$name = $value;
        return $this;
    }

    public function get(string $name, $default = null, bool $setDefault = false)
    {
        if (!$this->has($name) && true === $setDefault) {
            $this->set($name, $default);
        }
        return $this->$name ?? $default;
    }

    public function has(string $name): bool
    {
        return isset($this->$name);
    }
}

class BaseApp
{

    /** @var Container Di-контейнер приложения */
    protected static $di;

    public static function di(): Container
    {
        if (null === static::$di) {
            static::$di = new Container();
        }
        return static::$di;
    }

    public static function set(string $name, $value = null)
    {
        return static::di()->set($name, $value);
    }

    public static function has(string $name): bool
    {
        return static::di()->has($name);
    }

    public static function get(string $name, $default = null, bool $setDefault = false)
    {
        return static::di()->get($name, $default, $setDefault);
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
        static::$di = null;
    }

    public static function __callStatic(string $name, array $args = null)
    {
        if (static::has($name) && count($args) === 0) {
            return static::get($name);
        }
        if (count($args) > 0) {
            if ('set' === substr($name, 0, 3))  {
                $setName = lcfirst(substr($name, 3));
                return static::set($setName, $args[0]);
            } else {
                echo "set $name = {$args[0]}<br>";
                return static::set($name, $args[0])->get($name);
            }
        }
        echo "<b>$name, [" . implode(', ', $args) . ']</b><br>';
        $class = static::class;
        throw new \Exception("Call to undefined method {$class}::{$name}()");
    }

    public function __call(string $name, array $args = null)
    {
        return static::__callStatic($name, $args);
    }
}

class App0 extends BaseApp
{}
class App1 extends BaseApp
{
    // public $name = 'lol'; // Вот тут задаём свойство открыто!
    // protected static $di; // Вот тут задаём персональный контейнер!
}
class App2 extends BaseApp
{
    // public $name = 'lol'; // Вот тут задаём свойство открыто!
    protected static $di; // Вот тут задаём персональный контейнер!
}
class App3 extends BaseApp
{
    public $name = 'lol'; // Вот тут задаём свойство открыто!
    protected static $di; // Вот тут задаём персональный контейнер!
}
class App4 extends BaseApp
{
    public $name = 'lol'; // Вот тут задаём свойство открыто!
    // protected static $di; // Вот тут задаём персональный контейнер!
}
