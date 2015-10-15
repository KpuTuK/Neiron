<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Kernel\Http;

use Psr\Http\Message\RequestInterface;
/**
 * Description of Request
 *
 * @author KpuTuK
 */
class Request extends ServerRequest implements RequestInterface {

    /**
     * Dependency Injection Контейнер
     * @var \Neiron\Kernel\DependencyInjection\DependencyInjectionInterface
     */
    protected $container;
    /**
     * URI
     * @var \Psr\Http\Message\UriInterface
     */
    protected $uri;
}
