<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Response;

use Neiron\Arhitecture\Kernel\Response\ResponseHeadersInterface;
use Neiron\Arhitecture\Kernel\RequestInterface;

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
     * @param \Neiron\Arhitecture\Kernel\RequestInterface $request
     */
    public function __construct(array $headers, RequestInterface $request)
    {
        $list = array();
        foreach ($request->server() as $key => $value) {
            if (strpos($key, 'HTTP_') !== false) {
                $list[
                        ucfirst(substr(strtolower(strtr($key, '_', '-')), 5)) . ':'
                        ] = $value;
            }
        }
        $this->headers = array_replace($list, $headers);
        $this->cookies = $request->cookies->getAll(true);
    }
    /**
     * Удаляет/добавляет/выводит заголовки
     * @param mixed $name Массив заголовков или имя заголовка
     * @param string $value Содержимое заголовка
     * @return mixed
     */
    public function headers($name = null, $value = null)
    {
        if (is_array($name)) {
            return $this->headers = array_merge($this->headers, $name);
        }
        // Передача всего содержимого
        if ($name === null && $value === null) {
            return $this->headers;
        }
        // Проверка на наличие и передача переменной из массива
        if ($name !== null && $value === null) {
            if (array_key_exists($name, $this->headers)) {
                return $this->headers[$name];
            }
            return false;
        }
        // Запись переменной
        if ($name !== null && $value !== null) {
            return $this->headers[$name] = $value;
        }
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
        foreach ($this->headers as $key => $value) {
            header($key . ' ' . $value);
        }
        foreach ($this->cookies as $cookie) {
            setcookie(
                    $cookie['key'], $cookie['value'], $cookie['ttl'], $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']
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