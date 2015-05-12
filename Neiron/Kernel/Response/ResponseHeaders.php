<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Response;

use Neiron\API\Kernel\Response\ResponseHeadersInterface;
use Neiron\API\Kernel\RequestInterface;

/**
 * Класс для управления заголовками вывода
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class ResponseHeaders implements ResponseHeadersInterface
{
    private $cookies = array();
    /**
     * Массив заголовков
     * @var array
     */
    private $headers = array();
    /**
     * Конструктор класса
     * @param array $headers Массив заголовков
     * @param \Neiron\API\Kernel\RequestInterface $request
     */
    public function __construct(array $headers, RequestInterface $request)
    {
        
        $this->headers = $request->headers;
        $this->headers->merge($headers);
        $this->cookies = $request->cookie->getFromHeader();
    }
    /**
     * Отпраляет заголовки если они еще не были отправлены
     * @return \Neiron\Kernel\Response\ResponseHeaders
     */
    public function sendHeaders()
    {
        if (headers_sent()) {
            return $this;
        }
        foreach ((array)$this->headers as $key => $value) {
            header($key . ' ' . $value);
        }
        foreach ($this->cookies as $cookie) {
            setcookie(
                $cookie['key'],
                $cookie['value'],
                $cookie['ttl'],
                $cookie['path'],
                $cookie['domain'],
                $cookie['secure'],
                $cookie['httponly']
            );
        }
        return $this;
    }
    /**
     * Выводит массив кодировок
     * @return array
     */
    public function getEncodings()
    {
        return $this->parseAccept($this->headers['Accept-Encoding']);
    }
    /**
     * Выводит Accept заголовки
     * @return array
     */
    public function getAccepts()
    {
        $list = array();
        foreach ($this->parseAccept($this->headers['Accept']) as $accept) {
            if (strpos($accept, '/') !== false) {
                $list[] = $accept;
            }
        }
        return $list;
    }
    /**
     * Выводит массив языков
     * @return array
     */
    public function getLanguages()
    {
        $list = array();
        foreach ($this->parseAccept($this->headers['Accept-Language']) as $lang) {
            if (strpos($lang, '-') !== false) {
                $list[] = $lang;
            }
        }
        return $list;
    }
    /**
     * Прассит Accept Заголовки
     * @param string $accept
     * @return array
     */
    private function parseAccept($accept)
    {
        $list = array();
        foreach (explode(',', $accept) as $str) {
            foreach (explode(';', $str) as $param) {
                $list[] = $param;
            }
        }
        return $list;
    }
}