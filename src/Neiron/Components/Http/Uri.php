<?php
/**
 * PHP 5.4 framework с открытым иходным кодом
 */
namespace Neiron\Components\Http;

use Psr\Http\Message\UriInterface;
/**
 * Класс-обработчик URI
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 */
class Uri implements UriInterface {
    /**
     * Массив данных uri
     * @var array
     */
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
    /**
     * Создает новый экземпляр класса с указанным uri 
     * @param string $uri Строка uri
     */
    public function __construct($uri = '') {
        $this->parseUri = array_replace($this->parseUri, parse_url($uri));
    }
    /**
     * Выводит строку uri
     * @return string Строка uri
     */
    public function __toString() {
        return implode('', $this->parseUri);
    }
    /**
     * Формирует и возвращает данные авторизации
     * @return string Данные авторизации
     */
    public function getAuthority() {
        if (($this->parseUri['host'] === '') || 
                ($this->parseUri['user'] === '')) {
            return '';
        }
        $authority = $this->getUserInfo();
        $authority .= '@';
        $authority .= $this->getHost();
        $authority .= ($this->getPort() !== '') ? ':'.$this->getPort() : '';
        return $authority; 
    }
    /**
     * Возвращает фрагмент
     * @return string Фрагмент
     */
    public function getFragment() {
        return $this->parseUri['fragment'];
    }
    /**
     * Возвращает хост
     * @return string
     */
    public function getHost() {
        return $this->parseUri['host'];
    }
    /**
     * Возвращает путь
     * @return string
     */
    public function getPath() {
        return $this->parseUri['path'];
    }
    /**
     * Возвращает порт
     * @return string
     */
    public function getPort() {
        return $this->parseUri['port'];
    }
    /**
     * Возвращает данные запроса (после "?")
     * @return string
     */
    public function getQuery() {
        return $this->parseUri['query'];
    }
    /**
     * Возвращает схему запроса
     * @return string
     */
    public function getScheme() {
        return $this->parseUri['scheme'];
    }
    /**
     * Возвращает пароль и логин авторизации
     * @return string
     */
    public function getUserInfo() {
        return $this->parseUri['user'].':'.$this->parseUri['pass'];
    }
    /**
     * Возвращает экземпляр класса с заданым фрагментом
     * @param string $fragment
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withFragment($fragment) {
        $cloned = clone $this;
        $cloned->parseUri['fragment'] = (string)$fragment;
        return $cloned;
    }
    /**
     * Возвращает экземпляр класса с заданым хостом
     * @param string $host
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withHost($host) {
        $cloned = clone $this;
        $cloned->parseUri['host'] = (string)$host;
        return $cloned;
    }
    /**
     * Возвращает экземпляр класса с заданым путем
     * @param string $path
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withPath($path) {
        $cloned = clone $this;
        $cloned->parseUri['path'] = (string)$path;
        return $cloned;
    }
    /**
     * Возвращает экземпляр класса с заданым попртом
     * @param string $port
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withPort($port) {
        $cloned = clone $this;
        $cloned->parseUri['port'] = (int)$port;
        return $cloned;
    }
    /**
     * Возвращает экземпляр класса с задаными параметрами запроса
     * @param string $query
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withQuery($query) {
        $cloned = clone $this;
        $cloned->parseUri['query'] = (string)$query;
        return $cloned;
    }
    /**
     * Возвращает экземпляр класса с заданой схемой
     * @param string $scheme
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withScheme($scheme) {
        $cloned = clone $this;
        $cloned->parseUri['scheme'] = (string)$scheme;
        return $cloned;
    }
    /**
     * Возвращает экземпляр класса с задаными логином и паролем
     * @param string $user Логин
     * @param string $password Пароль
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withUserInfo($user, $password = null) {
        $cloned = clone $this;
        $cloned->parseUri['user'] = (string)$user;
        $cloned->parseUri['pass'] = (string)$password;
        return $cloned;
    }
}
