<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Components\Http;

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
    protected $parsedBody = [];
    
    /**
     * 
     * @param type $uri
     * @param array $server
     * @param array $query
     * @param array $parsedBody
     * @param array $cookies
     * @param array $files
     */
    public function __construct(
        $uri, 
        array $server = [], 
        array $query = [], 
        array $parsedBody = [],
        array $cookies = [],
        array $files = []
    ) {
        parent::__construct($uri, $server);
        $this->server = $server;
        $this->query = $query;
        $this->parsedBody = $parsedBody;
        $this->cookies = $cookies;
        if ( ! empty($files)) {
            foreach ($files as $key => $value) {
                $this->files[$key] = new UploadedFile($value);
            }
        }
    }
    public function getAttribute($name, $default = null) {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        } 
        return $default;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function getCookieParams() {
        return $this->cookies;
    }

    public function getParsedBody() {
        return $this->parsedBody;
    }

    public function getQueryParams() {
        return $this->query;
    }

    public function getServerParams() {
        return $this->server;
    }

    public function getUploadedFiles() {
        return $this->files;
    }

    public function withAttribute($name, $value) {
        $this->attributes[$name] = $value;
    }
    
    public function withCookieParams(array $cookies) {
        $this->cookies = array_merge($this->cookies, $cookies);
    }

    public function withParsedBody($data) {
        $this->parsedBody = array_merge($this->parsedBody, $data);
    }

    public function withQueryParams(array $query) {
        $this->query = array_merge($this->query, $query);
        $queryString = '';
        foreach ($query as $key => $value) {
            $queryString .= '&'.$key.'='.$value;
        }
        $this->uri->withQuery($queryString);
        return $this;
    }

    public function withUploadedFiles(array $uploadedFiles) {
        foreach ($uploadedFiles as $file) {
            if ( ! $file instanceof \Psr\Http\Message\UploadedFileInterface) {
                throw new \InvalidArgumentException('');
            }
        }
    }

    public function withoutAttribute($name) {
        
    }
}
