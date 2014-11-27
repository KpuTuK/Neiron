<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Kernel;
use Neiron\Arhitecture\Kernel\RequestInterface;
use Neiron\Arhitecture\Kernel\DIContainerInterface;
use Neiron\Kernel\Request\ControllerResolver;
/**
 * Description of Request
 *
 * @author KpuTuK
 */
class Request implements RequestInterface {
    /**
     * @var \Neiron\Arhitecture\Kernel\ApplicationInterface
     */
    private $container;
    private $globals = array();
    private $uri = null;
    private $method;
    public function __construct(DIContainerInterface $container) {
        $this->container = $container;
        $this->globals($GLOBALS);
        $this->method($this->server('REQUEST_METHOD'));
    }
    public function create($uri = null, $method = null) {
        return new ControllerResolver(
            $this->container['routing']->match(
                $this->decodeDetectUri($uri), 
                $this->method($method)
            ),
            $this->container
        );
    }
    private function decodeDetectUri($uri = null) {
        if ($uri === null) {
            if ( ! empty($this->server('PATH_INFO'))) {
                $uri = $this->server('PATH_INFO');
            }elseif ( ! empty($this->server('REQUEST_URI'))) {
                $uri = $this->server('REQUEST_URI');
            }
        }
        return $this->uri(rawurldecode(rtrim($uri, '/')));
    }
    /**
     * Задает/выдает (если есть) адрес страницы, которая привела браузер пользователя на эту страницу
     * @param string $refer Адрес страницы
     * @return mixed Если есть (или указан) адрес страницы то выдает его или возвращает false
     */
    public function referer($refer = null) {
        if ($refer != null) {
            $this->server('HTTP_REFERER', $refer);
        }
        if ($this->server('HTTP_REFERER') !== null) {
            return $this->server('HTTP_REFERER');
        }
        return false;
    }
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
    public function method($method = null) {
        return isset($method) ? $this->method = $method : $this->method;
    }
    public function uri($uri = null) {
        return isset($uri) ?  $this->uri = $uri : $this->uri;
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
