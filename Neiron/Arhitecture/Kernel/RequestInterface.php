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
    public function create($uri = null, $method = RequestInterface::METH_GET);
    public function globals($name = null, $value = null);
    public function server($name = null, $value = null);
    public function get($name = null, $value = null);
    public function post($name = null, $value = null);
}
