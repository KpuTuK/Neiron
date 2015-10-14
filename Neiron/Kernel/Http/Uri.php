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
     * Конструктор класса
     * @param string $uri Строка uri
     */
    public function __construct($uri) {
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
        if ($this->parseUri['host'] === '') {
            return '';
        } 
        if ($this->parseUri['user'] !== '') {
            return $this->getUserInfo() .'@'. $this->parseUri['host'];
        }
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
        return $this->parseUri['user'] .':'. $this->parseUri['pass'];
    }
    /**
     * Записывает фрагмент
     * @param string $fragment
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withFragment($fragment) {
        $this->parseUri['fragment'] = (string)$fragment;
        return $this;
    }
    /**
     * Записывает хост
     * @param string $host
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withHost($host) {
        $this->parseUri['host'] = (string)$host;
        return $this;
    }
    /**
     * Записывает путь
     * @param string $path
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withPath($path) {
        $this->parseUri['path'] = (string)$path;
        return $this;
    }
    /**
     * Записывает порт
     * @param string $port
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withPort($port) {
        $this->parseUri['port'] = (int)$port;
        return $this;
    }
    /**
     * Записывает данные запроса (после "?")
     * @param string $query
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withQuery($query) {
        $this->parseUri['query'] = (string)$query;
        return $this;
    }
    /**
     * Записывает схему
     * @param string $scheme
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withScheme($scheme) {
        $this->parseUri['scheme'] = (string)$scheme;
        return $this;
    }
    /**
     * Записывает логи и пароль авторизации
     * @param string $user Логин
     * @param string $password Пароль
     * @return \Neiron\Kernel\Http\Uri
     */
    public function withUserInfo($user, $password = null) {
        $this->parseUri['user'] = (string)$user;
        $this->parseUri['pass'] = (string)$password;
        return $this;
    }
}
