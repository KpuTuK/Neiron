<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Neiron\Kernel\Request;

use Neiron\Kernel\Helpers\ParameterManager;

/**
 * Description of HeaderManager
 *
 * @author KpuTuK
 */
class HeaderManager extends ParameterManager
{
    /**
     * @var array
     */
    private $cookie;
    public function __construct(array $server, array $cookie)
    {
        foreach ($server as $key => $value) {
            if (strpos($key, 'HTTP_') !== false) {
                $list[substr(strtr($key, '_', '-'), 5)] = $value;
            }
        }
        parent::__construct($list);
        $this->cookie = $cookie;
    }
    /**
     * Отпраляет заголовки если они еще не были отправлены
     * @return \Neiron\Kernel\Response\ResponseHeaders
     */
    public function sendHeaders()
    {
        if (headers_sent()) {
            return $this;
        }
        foreach ($this->parameters as $key => $value) {
            header($key . ' ' . $value);
        }
        foreach ($this->cookie as $cookie) {
            setcookie(
                $cookie['key'],
                $cookie['value'],
                $cookie['ttl'],
                $cookie['path'],
                $cookie['domain'],
                $cookie['secure'],
                $cookie['httponly']
            );
        }
        return $this;
    }
}