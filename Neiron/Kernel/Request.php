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
    private $globals;
    public function create($uri = null, $method = self::METH_GET) {}
    /**
     * @todo /
     * @param type $name
     * @param type $value
     * @return boolean
     */
    public function globals($name = null, $value = null) {
        // Слияние массивов с заменой
        if (is_array($name)) {
            $this->globals = array_merge($this->globals, $name);
        }
        // Передача всего содержимого
        if ($name === null && $value === null) {
            return $this->globals;
        }
        // Проверка на наличие и передача переменной из массива
        if ($name !== null && $value === null) {
            if (array_key_exists($name, $this->globals)) {
                return $this->globals[$name];
            }
            return false;
        }
        // Запись переменной
        if ($name !== null && $value !== null) {
            $this->globals[$name] = $value;
        }
    }
    /**
     * @todo ////
     * @param type $name
     * @param type $value
     */
    public function server($name = null, $value = null) {}
    /**
     * @todo //
     * @param type $name
     * @param type $value
     */
    public function get($name = null, $value = null) {}
    /**
     * @todo ///
     * @param type $name
     * @param type $value
     */
    public function post($name = null, $value = null) {}
}
