<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Kernel;
use Neiron\Arhitecture\Kernel\ApplicationInterface;
use Neiron\Arhitecture\Kernel\RequestInterface;
require_once dirname(__DIR__) . '/Arhitecture/Kernel/ApplicationInterface.php';
/**
 * Description of Neiron
 *
 * @author KpuTuK
 */
class Neiron implements ApplicationInterface {
    private $container = array();
    public function __construct(array $options = array()) {
        if ( ! isset($options['dir.root'])) {
            $options['dir.root'] = dirname(dirname(__DIR__)) .'/';
        }
        if ( ! isset($options['pathes'])) {
            $options['pathes'] = array();
        }
        $this->container = $options;
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
        $path .= $this['dir.root'];
        $path .= str_replace(
            array_keys($this['pathes']),
            array_values($this['pathes']), 
            $class
        );
        $path .= '.php';
        if (file_exists($path)) {
            require_once $path;
            return;
        }
        throw new \ErrorException(sprintf('Класс "%s" не найден!', $path));
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
