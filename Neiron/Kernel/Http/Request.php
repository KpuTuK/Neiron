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
    public function __construct($uri, $method) {
        parent::__construct($uri);
        $this->withMethod($method);
    }
    public function getMethod() {
        
    }

    public function getRequestTarget() {
        
    }

    public function getUri() {
        return (string) $this->uri->getScheme() . $this->uri->getAuthority() .
        $this->uri->getHost() . $this->uri->getPort() . $this->uri->getPath() .
        $this->uri->getQuery() . $this->uri->getFragment();
    }

    public function withMethod($method) {
        $this->server['HTTP_METHOD'] = $method;
    }

    public function withRequestTarget($requestTarget) {
        
    }

    public function withUri(\Psr\Http\Message\UriInterface $uri, $preserveHost = false) {
        
    }

    protected $uri;
}
