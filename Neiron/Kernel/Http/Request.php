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
class Request extends ServerRequest implements
    RequestInterface, RequestMethodInterface {
    public function __construct(
        $uri = '/',
        RequestMethodInterface $method = Request::METH_GET,
        array $server = array(), 
        array $query = array(), 
        array $parsedBody = array(), 
        array $cookies = array(), 
        array $files = array()
    ) {
        parent::__construct(
            $uri, $server, $query, $parsedBody, $cookies, $files
        );
        $this->withMethod($method);
    }
    public function getMethod() {
        return $this->getServerParams()['HTTP_METHOD'];
    }

    public function getRequestTarget() {
        
    }

    public function getUri() {
        return (string) $this->uri->getScheme() . $this->uri->getAuthority() .
        $this->uri->getPath() . $this->uri->getQuery() . $this->uri->getFragment();
    }

    public function withMethod($method) {
        $this->server['HTTP_METHOD'] = $method;
    }

    public function withRequestTarget($requestTarget) {
        
    }

    public function withUri(\Psr\Http\Message\UriInterface $uri, $preserveHost = false) {
        $this->uri = $uri;
        if (false === $preserveHost) {
            $this->withHeader('Host', $uri->getHost());
        }
    }
}
