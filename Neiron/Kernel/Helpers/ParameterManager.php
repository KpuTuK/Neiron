<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Helpers;

/**
 * Менеджер параметров
 * @author KpuTuK
 * @author Fabien Potencier <fabien@symfony.com>
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class ParameterManager implements \ArrayAccess, \Countable, \IteratorAggregate
{
    protected $parameters = array();
    public function __construct(array $parameters)
    {
            $this->parameters = $parameters;
    }
    public function merge(array $parameters)
    {
        $this->data = array_merge($this->parameters, $parameters);
    }
    public function getAll()
    {
        return $this->parameters;
    }
    public function getKeys()
    {
        return array_keys($this->parameters);
    }
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->parameters);
    }
    public function offsetSet($offset, $value)
    {
        $this->parameters[$offset] = $value;
    }
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->parameters[$offset];
        }
        return false;
    }
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->parameters[$offset]);
            return true;
        }
        return false;
    }
    public function count($mode = 'COUNT_NORMAL')
    {
        return count($this->parameters, $mode);
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->parameters);
    }
}