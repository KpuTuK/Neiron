<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;
use Neiron\Arhitecture\Kernel\RequestInterface;
/**
 * Класс для работы с cookie
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Cookies {
    private $cookies = array();
    private $fromHeader = array();
    public function __construct(RequestInterface $request) {
        $this->cookies = $request->globals('_COOKIE') ? 
            $request->globals('_COOKIE') : array();
    }
    /**
     * Сохраняет Cookie
     * @param string $key Наименование cookie
     * @param string $value Значение cookie
     * @param int $ttl Время, когда срок действия cookie истекает в часах
     * @param string $path Путь к директории на сервере, из которой будут доступны cookie
     * @param string $domain Домен, которому доступны cookie
     * @param bool $secure Указывает на то, что значение cookie должно передаваться от клиента по защищенному HTTPS соединению
     * @param bool $httpOnly Если задано TRUE, cookie будут доступны только через HTTP протокол
     */
    public function set(
        $key,
        $value,
        $ttl = 1,
        $path = '/',
        $domain = null,
        $secure = null,
        $httpOnly = true
    ) {
        $this->fromHeader[] = array(
            'key' => $key,
            'value' => $value,
            'ttl' => time() + ($ttl * 3600),
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httpOnly' => $httpOnly
        );
        $this->cookies[$key] = $value;
    }
    /**
     * Возвращает содержимое cookie
     * @param string $key Наименование cookie
     * @return mixed Если cookie задана то вернет ее содержимое если нет то false
     */
    public function get($key) {
        if (isset($this->cookies[$key])) {
            return $this->cookies[$key];
        }
        return false;
    }
    /**
     * Удаляет cookie
     * @param string $key Наименование cookie
     */
    public function remove($key) {
        if (isset($this->cookies[$key])) {
            $this->set($key, '', -24*3600);
        }
    }
    /**
     * Возвращает массив всех cookie
     * @param bool $fromHeaders Если параметр true то вернет массив для заголовков
     * @return type
     */
    public function getAll($fromHeaders = false) {
        if ($fromHeaders) {
            return $this->fromHeader;
        }
        return $this->cookies;
    }
}
