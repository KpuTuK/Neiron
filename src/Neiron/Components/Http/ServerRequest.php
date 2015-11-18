<?php
/**
* PHP 5.4 framework с открытым иходным кодом
*/

namespace Neiron\Components\Http;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Обработчик сообщений запроса
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Http-component
 */
abstract class ServerRequest extends Message implements ServerRequestInterface {
    /**
     * Атрибуты запроса
     * @var /ArrayObject 
     */
    protected $attributes;
    /**
     * COOKIE запроса
     * @var /ArrayObject
     */
    protected $cookies;
    /**
     * SERVER данные запроса
     * @var /ArrayObject
     */
    protected $server;
    /**
     * GET данные запроса
     * @var /ArrayObject
     */
    protected $query;
    /**
     * Загруженные файлы запроса
     * @var /ArrayObject
     */
    protected $files;
    /**
     * POST данные запроса
     * @var /ArrayObject
     */
    protected $parsedBody;
    /**
     * Создает экземпляр класса с указанными параметрами
     * @param mixed $uri
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
        array $files = [],
        array $attributes = []
    ) {
        parent::__construct($uri, $server);
        $this->server = new \ArrayObject($server);
        $this->query = new \ArrayObject($query);
        $this->parsedBody = new \ArrayObject($parsedBody);
        $this->cookies = new \ArrayObject($cookies);
        $this->files = new \ArrayObject();
        $this->attributes = new \ArrayObject($attributes);
        $this->files = new \ArrayObject(
            $this->withUploadedFiles($files)->getUploadedFiles()
        );
    }
    /**
     * Возврашает содкржимое указанного ключа при наличии или значение по умолчанию
     * @param mixed $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($name, $default = null) {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        } 
        return $default;
    }
    /**
     * Возвращает массив с атрибутами запроса
     * @return /ArrayObject
     */
    public function getAttributes() {
        return $this->attributes;
    }
    /**
     * Возвращает массив с COOKIES запроса
     * @return /ArrayObject
     */
    public function getCookieParams() {
        return $this->cookies;
    }
    /**
     * Возвращает массив с POST данными запроса
     * @return /ArrayObject
     */
    public function getParsedBody() {
        return $this->parsedBody;
    }
    /**
     * Возвращает массив с GET данными запроса
     * @return /ArrayObject
     */
    public function getQueryParams() {
        return $this->query;
    }
    /**
     * Возвращает переменные SERVER
     * @return /ArrayObject
     */
    public function getServerParams() {
        return $this->server;
    }
    /**
     * Вовращает загруженные файлы
     * @return /ArrayObject
     */
    public function getUploadedFiles() {
        return $this->files;
    }
    /**
     * Возвращает клон экземпляра класса с указанным именем и значенем аттрибута
     * @param string $name
     * @param mixed $value
     * @return \Neiron\Components\Http\ServerRequest
     */
    public function withAttribute($name, $value) {
        $cloned = clone $this;
        $cloned->attributes[$name] = $value;
        return $cloned;
    }
    /**
     * Возвращает клон экземпляра класса с указанными cookies
     * @param array $cookies
     * @return \Neiron\Components\Http\ServerRequest
     */
    public function withCookieParams(array $cookies) {
        $cloned = $this;
        $cloned->cookies = new \ArrayObject($cookies);
        return $cloned;
    }
    /**
     * Возвращает клон экземпляра класса с указанным(и) POST данным(и) запроса
     * @param mixed $data
     * @return \Neiron\Components\Http\ServerRequest
     */
    public function withParsedBody($data) {
        $cloned = $this;
        if ( ! is_array($data)) {
            $data = [$data];
        }
        $cloned->parsedBody = new \ArrayObject($data);
        $this->attributes['__body__'] = $data;
        return $cloned;
    }
    /**
     * Возвращает клон экземпляра класса с указанными GET данными запроса
     * @param array $query
     * @return \Neiron\Components\Http\ServerRequest
     */
    public function withQueryParams(array $query) {
        $cloned = clone $this;
        $cloned->query = new \ArrayObject($query);
        $queryString = '';
        foreach ($query as $key => $value) {
            $queryString .= '&'.$key.'='.$value;
        }
        $this->uri = $this->uri->withQuery($queryString);
        return $this;
    }
    /**
     * Возвращает клон экземпляра класса с указанными файлами
     * @param array $uploadedFiles
     * @return \Neiron\Components\Http\ServerRequest
     * @throws \InvalidArgumentException
     */
    public function withUploadedFiles(array $uploadedFiles) {
        $cloned = $this; 
        foreach ($uploadedFiles as $file) {
            if (
                !is_object($file) || 
                (! $file instanceof \Psr\Http\Message\UploadedFileInterface)
            ) {
                throw new \InvalidArgumentException(
                    'Недопустимый тип файла!'
                );
            }
            $cloned->files[] = $file;
        }
        return $cloned;
    }
    /**
     * Возвращает клон экземпляра класса без указанного параметра
     * @param string $name
     * @return \Neiron\Components\Http\ServerRequest
     * @throws \InvalidArgumentException
     */
    public function withoutAttribute($name) {
        $clone = clone $this;
        if (isset($clone->attributes[$name])) {
            unset($clone->attributes[$name]);
            return $clone;
        }
        throw new \InvalidArgumentException(vsprintf(
            'Атрибут "%s" не сужествует', 
            $name
        ));
    }
}
