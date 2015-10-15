<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Kernel\Http;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Description of Message
 *
 * @author KpuTuK
 */
class Message implements MessageInterface {
    protected $protocol = '1.0';
    protected $headers = [];
    public function getBody() {
        
    }

    public function getHeader($name) {
        
    }

    public function getHeaderLine($name) {
        
    }

    public function getHeaders() {
        
    }

    public function getProtocolVersion() {
        return $this->protocol;
    }

    public function hasHeader($name) {
        
    }

    public function withAddedHeader($name, $value) {
        
    }

    public function withBody(StreamInterface $body) {
        
    }

    public function withHeader($name, $value) {
        
    }

    public function withProtocolVersion($version) {
        $this->protocol = (string)$version;
        return $this;
    }

    public function withoutHeader($name) {
        
    }
}
