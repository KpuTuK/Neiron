<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Http;

/**
 * Класс-обработчик URI
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 * @todo Добавить проверки методов with...() 
 *      согласно http://www.php-fig.org/psr/psr-7/
 */
class Uri implements \Psr\Http\Message\UriInterface {
    protected $parseUri = [
        'scheme' => '',
        'host' => '',
        'port' => '',
        'user' => '',
        'pass' => '',
        'path' => '',
        'query' => '',
        'fragment' => '',
    ];
    public function __construct($uri) {
        array_replace($this->parseUri, parse_url($uri));
    }
    public function __toString() {
        return implode('', $this->parseUri);
    }

    public function getAuthority() {
        if ($this->parseUri['host'] === '') {
            return '';
        } 
        if ($this->parseUri['user'] !== '') {
            return $this->getUserInfo() .'@'. $this->parseUri['host'];
        }
    }

    public function getFragment() {
        return $this->parseUri['fragment'];
    }

    public function getHost() {
        return $this->parseUri['host'];
    }

    public function getPath() {
        return $this->parseUri['path'];
    }

    public function getPort() {
        return $this->parseUri['port'];
    }

    public function getQuery() {
        return $this->parseUri['query'];
    }

    public function getScheme() {
        return $this->parseUri['scheme'];
    }

    public function getUserInfo() {
        return $this->parseUri['user'] .':'. $this->parseUri['pass'];
    }

    public function withFragment($fragment) {
        $this->parseUri['fragment'] = (string)$fragment;
        return $this;
    }

    public function withHost($host) {
        $this->parseUri['host'] = (string)$host;
        return $this;
    }

    public function withPath($path) {
        $this->parseUri['path'] = (string)$path;
        return $this;
    }

    public function withPort($port) {
        $this->parseUri['port'] = (int)$port;
        return $this;
    }

    public function withQuery($query) {
        $this->parseUri['query'] = (string)$query;
        return $this;
    }

    public function withScheme($scheme) {
        $this->parseUri['scheme'] = (string)$sheme;
        return $this;
    }

    public function withUserInfo($user, $password = null) {
        $this->parseUri['user'] = (string)$user;
        $this->parseUri['pass'] = (string)$password;
        return $this;
    }
}
