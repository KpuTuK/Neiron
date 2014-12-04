<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Neiron\Kernel\Request;

/**
 * 
 * 
 */
class ParameterManager implements \ArrayAccess
{
    private $data = array();
    public function __construct(array $data)
    {
        $this->data;
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