<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;

/**
 * Dependency injection Контейнер
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class DIContainer
{
    /**
     * Контейнер
     * @var array
     */
    protected $container = [];
    /**
     * Конструктор класса
     * @param array $values 
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $offset => $value) {
            $this->offsetSet($offset, $value);
        }
    }
    /**
     * Создает функцию при вызове которой каждый раз будет вызван конструктор класса
     * @param string $name Имя функции
     * @param mixed $class Пространство имен или обьект класса
     */
    public function setInstance($name, $class)
    {
        $this->offsetSet($name, function ($values) use ($class) {
            if (is_object($class)) {
                return (new \ReflectionObject($class))->newInstance($values);
            }
            return new $class($values);
        });
    }
    /**
     * Меняет содержимое в контейнере по ключу
     * @param string $name
     * @param mixed $value
     */
    public function rewind($name, $value)
    {
        if ($this->offsetExists($name)) {
            $this->offsetUnset($name);
            return $this->offsetSet($name, $value);
        }
        throw new \InvalidArgumentException(
            sprintf('Параметр "%s" уже существует!', $name)
        );
    }
    /**
     * Проверяет наличие параметра в контейнере
     * @param string $offset Проверяемый параметр
     * @return bool true параметр найден или false если параметр отсутсвует
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->container);
    }
    /**
     * Сохраняет содержимое в контейнер по ключу
     * @param string $offset Ключ
     * @param mixed $value Сохраняемое содержимое
     * @throws \InvalidArgumentException Исключение выбрасываемое в случае если ключ уже существует в контейнере
     */
    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            throw new \InvalidArgumentException(
            sprintf('Параметр "%s" уже существует!', $offset)
            );
        }
        $this->container[$offset] = $value;
    }
    /**
     * Возвращает содержимое контейнера по ключу
     * @param string $offset Ключ содержимого
     * @return mixed Содержимое
     * @throws \InvalidArgumentException Исключение выбрасываемое в случае отсутствия ключа в контейнере
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \InvalidArgumentException(
            sprintf('Параметр "%s" не существует!', $offset)
            );
        }
        return $this->container[$offset];
    }
    /**
     * Удаляет содержимое по ключу в контейнере
     * @param string $offset Ключ содержимого
     * @throws \InvalidArgumentException Исключение выбрасываемое в случае отсутствия ключа в контейнере
     */
    public function offsetUnset($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \InvalidArgumentException(
            sprintf('Параметр "%s" не существует!', $offset)
            );
        }
        unset($this->container[$offset]);
    }
    public function __call($name, $arguments) {
        if ($this->offsetExists($name) &&
            $this->offsetGet($name) instanceof \Closure)  {
            return $this{$name}($arguments);
        }
        throw new \InvalidArgumentException(sprintf(
            'Параметр "%s" не существует или не являеться анонимной функцией!',
            $name
        ));
    }
}