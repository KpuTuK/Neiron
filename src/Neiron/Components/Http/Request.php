<?php
/**
* PHP 5.4 framework с открытым иходным кодом
*/

namespace Neiron\Components\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
/**
 * Обработчик запросов к HTTP серверу
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Http-component
 */
class Request extends ServerRequest implements 
    RequestMethodInterface, 
    RequestInterface 
{
    /**
     * Целевой запрос
     * @var string
     */
    protected $requestTraget = '/';
    /**
     * Иницилизирует класс с набором данных запроса
     * @param string $uri Запрашиваемый URI
     * @param string $method Метод запроса
     * @param array $server Массив имитирующий $_SERVER
     * @param array $query Массив имитирующий $_GET
     * @param array $parsedBody Массив имитирующий $_POST
     * @param array $cookies Массив имитирующий $_COOKIE
     * @param array $files Массив имитирующий $_FILES
     */
    public function __construct(
        $uri = '/',
        $method = Request::METH_GET,
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
    /**
     * Возвращает метод запроса
     * @return string
     */
    public function getMethod() {
        return $this->getServerParams()['HTTP_METHOD'];
    }
    /**
     * Возвращает целевой URI
     * @return string
     */
    public function getRequestTarget() {
        return $this->requestTraget;
    }
    /**
     * Возвращает обьект класса реализующего \Psr\Http\Message\UriInterface
     * @return \Psr\Http\Message\UriInterface
     */
    public function getUri() {
        return $this->uri;
    }
    /**
     * Возвращает клон класса с указанным методом запроса
     * @param string $method
     * @return \Neiron\Components\Http\Request
     */
    public function withMethod($method) {
        $cloned = $this;
        $cloned->server['HTTP_METHOD'] = $method;
        return $cloned;
    }
    /**
     * Возвращает клон класса с указанным целевым URI
     * @param string $requestTarget
     * @return \Neiron\Components\Http\Request
     */
    public function withRequestTarget($requestTarget) {
        $cloned = $this;
        $cloned->requestTraget = $requestTarget;
        return $cloned;
    }
    /**
     * Возвращает клон класса с указанным URI 
     * @param \Psr\Http\Message\UriInterface $uri
     * @param bool $preserveHost 
     */
    public function withUri(UriInterface $uri, $preserveHost = false) {
        $cloned = $this;
        $cloned->uri = $uri;
        if (false === $preserveHost) {
            $cloned->withHeader('Host', $uri->getHost());
        }
        return $cloned;
    }
}
