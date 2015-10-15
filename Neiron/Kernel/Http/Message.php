<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Http;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Обработчик сообщений запроса
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Http-component
 * @link
 */
class Message implements MessageInterface {
    const HEADER_SEP = ': ';
    protected $protocol = '1.0';
    protected $headers = [];
    protected $body;
    /**
     * Возвращает тело сообщения
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getBody() {
        return $this->body;
    }
    /**
     * Возвращает все значения указанного заголовка сообщения
     * @param string $name Имя заголовка без учета регистра
     * @return type
     */
    public function getHeader($name) {
        $headerName = ucfirst($name);
        if ($this->hasHeader($headerName)) {
            return $this->headers[$headerName];
        }
    }
    /**
     * Возвращает указанный заголовок в виде сторки
     * @param string $name Имя заголовка без учета регистра
     * @return string Заголовок в виде сторки
     */
    public function getHeaderLine($name) {
        $headerName = ucfirst($name);
        if ($this->hasHeader($headerName)) {
            if (is_string($this->headers[$headerName])) {
                return (string)$headerName . 
                self::HEADER_SEP . $this->headers[$headerName];
            } else {
                return (string)$headerName . self::HEADER_SEP .
                implode(', ', $this->headers[$headerName]);
            }
        }
    }
    /**
     * Возвращает все значения заголовков сообщения
     * @return array Ассоциативный массив заголовков
     */
    public function getHeaders() {
        return $this->headers;
    }
    /**
     * Возвращает версию протокола ввиде строки
     * @return string Версия протокола
     */
    public function getProtocolVersion() {
        return $this->protocol;
    }
    /**
     * Проверяет наличие указанного заголовка
     * @param string $name Имя заголовка без учета регистра
     * @return bool True если заголовок присутствует или false если отсутствует
     */
    public function hasHeader($name) {
        return array_key_exists($name, $this->headers);
    }
    /**
     * Возвращает экземпляр класса с заменой значения указанного заголовка
     * @param string $name Имя заголовка без учета регистра
     * @param array|string $value Значение указанного заголовка
     * @return \Neiron\Kernel\Http\Message
     */
    public function withAddedHeader($name, $value) {
        $headerName = ucfirst($name);
        if ($this->hasHeader($headerName)) {
            $this->headers[$headerName] = ucfirst($value);
        }
        return $this;
    }
    /**
     * Возвращает экземпляр класса с указанным телом сообщения
     * @param StreamInterface $body
     * @return \Neiron\Kernel\Http\Message
     */
    public function withBody(StreamInterface $body) {
        $this->body = $body;
        return $this;
    }
    /**
     * Возвращает экземпляр класса с заменой указанного заголовка
     * @param string $name Имя заголовка без учета регистра
     * @param type $value
     * @return \Neiron\Kernel\Http\Message
     */
    public function withHeader($name, $value) {
        $headerName = ucfirst($name);
        if (!$this->hasHeader($headerName)) {
            $this->headers[$headerName] = ucfirst((string)$value);
        }
        return $this;
    }
    /**
     * Принимает версию HTTP протокола
     * @param string $version версия HTTP протокола
     * @return \Neiron\Kernel\Http\Message
     */
    public function withProtocolVersion($version) {
        $this->protocol = (string)$version;
        return $this;
    }
    /**
     * Возвращает экземпляр класса без указанного заголовка
     * @param string $name Имя заголовка без учета регистра
     * @return \Neiron\Kernel\Http\Message
     */
    public function withoutHeader($name) {
        $headerName = ucfirst($name);
        if ($this->hasHeader($headerName)) {
            unset($this->headers[$headerName]);
        }
        return $this;
    }
}
