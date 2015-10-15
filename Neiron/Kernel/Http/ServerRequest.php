<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Kernel\Http;

use Psr\Http\Message\ServerRequestInterface;
/**
 * Description of ServerRequest
 *
 * @author KpuTuK
 */
abstract class ServerRequest extends Message implements ServerRequestInterface {
    protected $attributes = [];
    protected $cookies = [];
    protected $server = [];
    protected $query = [];
    protected $files = [];
    public function getAttribute($name, $default = null) {
        
    }

    public function getAttributes() {
        
    }

    public function getCookieParams() {
        
    }

    public function getParsedBody() {
        
    }

    public function getQueryParams() {
        
    }

    public function getServerParams() {
        
    }

    public function getUploadedFiles() {
        
    }

    public function withAttribute($name, $value) {
        
    }

    public function withCookieParams(array $cookies) {
        
    }

    public function withParsedBody($data) {
        
    }

    public function withQueryParams(array $query) {
        
    }

    public function withUploadedFiles($uploadedFiles) {
        
    }

    public function withoutAttribute($name) {
        
    }

}
