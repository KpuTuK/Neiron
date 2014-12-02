<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Neiron\Kernel\Utils;

/**
 * Description of ParamManager
 *
 * @author KpuTuK
 */
class ParamManager implements \ArrayAccess
{
    private $parmetrs = array();
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->parmetrs);
    }
    public function offsetSet($offset, $value)
    {
        if ( ! $this->offsetExists($offset)) {
            $this->parmetrs[$offset] = $value;
            return true;
        }
        return false;
    }
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->parmetrs[$offset];
        }
        return false;
    }
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->parmetrs[$offset]);
            return true;
        }
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
    /**
     * @todo Добавить set(), unset(), get()?
     */
}