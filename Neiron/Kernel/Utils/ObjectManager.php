<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Neiron\Kernel\Utils;

/**
 * Description of ObjectManager
 *
 * @author KpuTuK
 */
class ObjectManager implements \ArrayAccess
{
    private $object = false;
    public function __construct($object)
    {
        $this->object = (object)$object;
    }
    public function offsetExists($offset)
    {
        if (method_exists($this->object ? $this->object : $this, $offset)) {
            return true;
        }
        return false;
    }
    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            if ($this->object) {
                $this->object->$offset($value);
            } else {
                $this->$offset($value);
            }
            return true;
        }
        return false;
    }
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            if ($this->object) {
                return $this->object->$offset();
            }
            return $this->$offset();
        }
    }
    public function offsetUnset($offset)
    {
        return false;
    }
    public function __isset($name)
    {
        return $this->offsetExists($name);
    }
    public function __set($name, $value)
    {
        return $this->offsetSet($name, $value);
    }
    public function __get($name)
    {
        return $this->offsetGet($name);
    }
    public function __unset($name)
    {
        return $this->offsetUnset($name);
    }
}