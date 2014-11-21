<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Kernel;
use Neiron\Arhitecture\Kernel\RequestInterface;
/**
 * Description of Request
 *
 * @author KpuTuK
 */
class Request implements RequestInterface {
    private $globals = array();
    public function __construct() {
        $this->globals($GLOBALS);
    }
    public function create($uri = null, $method = self::METH_GET) {}
    /**
     * @param type $name
     * @param type $value
     * @return boolean
     */
    public function globals($name = null, $value = null, $var = false) {
        $glob = $var ? $this->globals[$var] : $this->globals;
        // Слияние массивов с заменой
        if (is_array($name)) {
            return $this->globals = array_merge($glob, $name);
        }
        // Передача всего содержимого
        if ($name === null && $value === null) {
            return $glob;
        }
        // Проверка на наличие и передача переменной из массива
        if ($name !== null && $value === null) {
            if (array_key_exists($name, $glob)) {
                return $glob[$name];
            }
            return false;
        }
        // Запись переменной
        if ($name !== null && $value !== null) {
           return $glob[$name] = $value;
        }
    }
    /**
     * @param type $name
     * @param type $value
     */
    public function server($name = null, $value = null) {
        return $this->globals($name, $value, '_SERVER');
    }
    /**
     * @param type $name
     * @param type $value
     */
    public function get($name = null, $value = null) {
        return $this->globals($name, $value, '_GET');
    }
    /**
     * @param type $name
     * @param type $value
     */
    public function post($name = null, $value = null) {
        return $this->globals($name, $value, '_POST');
    }
}
