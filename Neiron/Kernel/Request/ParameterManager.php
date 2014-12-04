<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Request;

/**
 * Менеджер параметров
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class ParameterManager implements \ArrayAccess
{
    private $data = array();
    public function __construct(array $data)
    {
            $this->data = $data;
    }
    public function merge(array $data = array())
    {
        $this->data = array_merge($this->data, $data);
    }
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->data[$offset];
        }
        return false;
    }
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
            return true;
        }
        return false;
    }
}