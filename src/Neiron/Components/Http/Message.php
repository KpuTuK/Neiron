<?php
/**
* PHP 5.4 framework с открытым иходным кодом
*/

namespace Neiron\Components\Http;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * Обработчик сообщений запроса
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Http-component
 */
class Message implements MessageInterface {
    /**
     * Версия протокола
     * @var string 
     */
    protected $protocol = '1.0';
    /**
     * Массив заголовков
     * @var array
     */
    protected $headers = [];
    /**
     * Тело сообщения
     * @var \Psr\Http\Message\StreamInterface 
     */
    protected $body;
    /**
     * Обработчик uri
     * @var \Psr\Http\Message\UriInterface
     */
    protected $uri;
    /**
     * Иницилизирует класс с набором заголовков из $_SERVER
     * @param array $serverVars
     */
    public function __construct($uri, array $serverVars = []) {
        if ($uri instanceof UriInterface) {
            $this->uri = $uri;
        } else {
            $this->uri = new Uri($uri);
        }
        foreach ($serverVars as $key => $value) {		
            if (strpos($key, 'HTTP_') !== false) {		
                $this->headers[substr(strtr($key, '_', '-'), 5)] = $value;		
            }		
        }
    }
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
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getHeader($name) {
        $headerName = ucfirst($name);
        if ($this->hasHeader($headerName)) {
            return $this->headers[$headerName];
        }
        throw new \InvalidArgumentException(vsprintf(
            'Заголовок "%s" не найден! ', $headerName
        ));
    }
    /**
     * Возвращает указанный заголовок в виде сторки
     * @param string $name Имя заголовка без учета регистра
     * @return string Заголовок в виде сторки
     * @throws \InvalidArgumentException
     */
    public function getHeaderLine($name) {
        $headerName = ucfirst($name);
        if ($this->hasHeader($headerName)) {
            if (is_string($this->headers[$headerName])) {
                return (string)$headerName.': '.$this->headers[$headerName];
            }
            return (string)$headerName.': '.
            implode(', ', $this->headers[$headerName]);
        }
        throw new \InvalidArgumentException(vsprintf(
            'Заголовок "%s" не найден! ', $headerName
        ));
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
     * Возвращает клон экземпляра класса с заменой значения указанного заголовка
     * @param string $name Имя заголовка без учета регистра
     * @param array|string $value Значение указанного заголовка
     * @return \Neiron\Components\Http\Message
     * @throws \InvalidArgumentException
     */
    public function withAddedHeader($name, $value) {
        $headerName = ucfirst($name);
        $cloned = clone $this;
        if ($cloned->hasHeader($headerName)) {
            $cloned->headers[$headerName] = $value;
            unset($cloned->headers[$headerName]);
            return $cloned;
        }
        throw new \InvalidArgumentException(vsprintf(
            'Заголовок "%s" не найден! ', $headerName
        ));
    }
    /**
     * Возвращает клон экземпляра класса с указанным телом сообщения
     * @param \Psr\Http\Message\StreamInterface $body Тело сообщения
     * @return \Neiron\Components\Http\Message
     */
    public function withBody(StreamInterface $body) {
        $cloned = clone $this;
        $cloned->body = $body;
        return $this;
    }
    /**
     * Возвращает клон экземпляра класса с заменой указанного заголовка
     * @param string $name Имя заголовка без учета регистра
     * @param string $value Содержимое заголовка
     * @return \Neiron\Components\Http\Message
     */
    public function withHeader($name, $value) {
        $cloned = clone $this;
        $cloned->headers[ucfirst($name)] = $value;
        return $cloned;
    }
    /**
     * Возвращает клон экземпляра класса с заменой указанного протокола
     * @param string $version версия HTTP протокола
     * @return \Neiron\Components\Http\Message
     */
    public function withProtocolVersion($version) {
        $cloned = clone $this;
        $cloned->protocol = (string)$version;
        return $cloned;
    }
    /**
     * Возвращает клон экземпляра класса без указанного заголовка
     * @param string $name Имя заголовка без учета регистра
     * @return \Neiron\Components\Http\Message
     * @throws \InvalidArgumentException
     */
    public function withoutHeader($name) {
        $headerName = ucfirst($name);
        $cloned = clone $this;
        if ($cloned->hasHeader($headerName)) {
            unset($cloned->headers[$headerName]);
            return $cloned;
        }
        throw new \InvalidArgumentException(vsprintf(
            'Заголовок "%s" не найден! ', $headerName
        ));
    }
}
