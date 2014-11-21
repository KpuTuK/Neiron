<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Kernel;
use Neiron\Arhitecture\ApplicationInterface;
use Neiron\Arhitecture\Kernel\RequestInterface;
/**
 * Description of Neiron
 *
 * @author KpuTuK
 */
class Neiron implements ApplicationInterface {
    private $container = array();
    public function __construct() {
        spl_autoload_register(array($this, 'classLoader'), false);
        $this['routing'] = new Routing();
    }
    public function get($name, $pattern, $handler) {
        return $this['routing']->addRoute($name, $pattern, $handler, RequestInterface::METH_GET);
    }
    public function post($name, $pattern, $handler) {
        return $this['routing']->addRoute($name, $pattern, $handler, RequestInterface::METH_POST);
    }
    public function put($name, $pattern, $handler) {
        return $this['routing']->addRoute($name, $pattern, $handler, RequestInterface::METH_PUT);
    }
    public function delete($name, $pattern, $handler) {
        return $this['routing']->addRoute($name, $pattern, $handler, RequestInterface::METH_DELETE);
    }
    public function classLoader($class) {
        $class .= $this['dir.root'];
        if (isset($this['pathes'])) {
            $class .= str_replace(
                array_keys($this['pathes']),
                array_values($this['pathes']), 
                $class
            );
        }
        $class .= '.php';
        if (file_exists($class)) {
            require_once $class;
            return;
        }
        throw new \ErrorException(sprintf('Класс "%s" не найден!', $class));
    }
    public function offsetExists($offset) {
        return array_key_exists($offset, $this->container);
    }
    public function offsetSet($offset, $value) {
        if ($this->offsetExists($offset)) {
            throw new \InvalidArgumentException();
        }
        $this->container[$offset] = $value;
    }
    public function offsetGet($offset) {
        if ( ! $this->offsetExists($offset)) {
            throw new \InvalidArgumentException();
        }
        return $this->container[$offset];
    }
    public function offsetUnset($offset) {
        if ( ! $this->offsetExists($offset)) {
            throw new \InvalidArgumentException();
        }
        unset($this->container[$offset]);
    }
}
