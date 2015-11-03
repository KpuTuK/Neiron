<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Components\DependencyInjection;

/**
 * Dependency injection Контейнер
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Dependency injection
 * @link
 */
class DependencyInjection implements DependencyInjectionInterface
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
        $this->offsetSet($name, function($values) use ($class) {
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
        $this->exceptionOffsetExists($name, false);
        $this->offsetUnset($name);
        return $this->offsetSet($name, $value);
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
     * @throws \InvalidArgumentException 
     */
    public function offsetSet($offset, $value)
    {
        $this->exceptionOffsetExists($offset, true);
        $this->container[$offset] = $value;
    }
    /**
     * Возвращает содержимое контейнера по ключу
     * @param string $offset Ключ содержимого
     * @return mixed Содержимое
     * @throws \InvalidArgumentException 
     */
    public function offsetGet($offset)
    {
        $this->exceptionOffsetExists($offset, false);
        return $this->container[$offset];
    }
    /**
     * Удаляет содержимое по ключу в контейнере
     * @param string $offset Ключ содержимого
     * @throws \InvalidArgumentException 
     */
    public function offsetUnset($offset)
    {
        $this->exceptionOffsetExists($offset, false);
        unset($this->container[$offset]);
    }
    /**
     * 
     * @param string $name
     * @param string $arguments
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function __call($name, $arguments) {
        if ($this->offsetExists($name) &&
            $this->offsetGet($name) instanceof \Closure) {
            return $this{$name}($arguments);
        }
        throw new \InvalidArgumentException(sprintf(
            'Параметр "%s" не существует или не является анонимной функцией!',
            $name
        ));
    }
    /**
     * Проверяет наличие/отсутствие ключа в контейнере в зависимоси от режима
     * @param string $offset
     * @param bool $mode
     * @throws \InvalidArgumentException
     */
    protected function exceptionOffsetExists($offset, $mode = false) {
        if ((false === $mode) && (false === $this->offsetExists($offset))) {
            throw new \InvalidArgumentException(
            sprintf('Параметр "%s" не существует!', $offset)
            );
        }
        if ((true === $mode) && (true === $this->offsetExists($offset))) {
            throw new \InvalidArgumentException(
            sprintf('Параметр "%s" уже существует!', $offset)
            );
        }
    }
}