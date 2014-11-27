<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Arhitecture\Kernel;

/**
 *
 * @author KpuTuK
 */
interface RequestInterface {
    const METH_GET = 'GET';
    const METH_POST = 'POST';
    const METH_PUT = 'PUT';
    const METH_DELETE = 'DELETE';
    public function create($uri = null, $method = null);
    public function globals($name = null, $value = null);
    public function uri($uri = null);
    public function method($method = null);
    public function server($name = null, $value = null);
    public function get($name = null, $value = null);
    public function post($name = null, $value = null);
    /**
     * Задает/выдает (если есть) адрес страницы, которая привела браузер пользователя на эту страницу
     * @param string $refer Адрес страницы
     * @return mixed Если есть (или указан) адрес страницы то выдает его или возвращает false
     */
    public function referer($refer = null);
}
