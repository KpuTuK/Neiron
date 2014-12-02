<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;

use Neiron\API\Kernel\RequestInterface;
use Neiron\API\Kernel\DIContainerInterface;
use Neiron\API\Kernel\Request\ControllerResolverInterface;

/**
 * Обработчик запросов к серверу
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Request implements RequestInterface
{
    /**
     * @var ControllerResolverInterface
     */
    private $resolver;
    /**
     * Обьект класса для работы с cookie
     * @var \Neiron\API\Kernel\CookieInterface
     */
    public $cookies;
    /**
     * Обьект Dependency injection контейнера
     * @var \Neiron\API\Kernel\DIContainerInteface
     */
    private $container;
    private $globals = array();
    private $uri = null;
    /**
     * Конструктор класса
     * @param \Neiron\API\Kernel\DIContainerInterface $container
     */
    public function __construct(
        DIContainerInterface $container, 
        ControllerResolverInterface $resolver
    ) {
        $this->container = $container;
        $this->globals($GLOBALS);
        $this->cookies = $container['cookie'];
        $this->cookies->setAll(
            $this->globals('_COOKIE') ? $this->globals('_COOKIE') : array()
        );
        $this->resolver = $resolver;
    }
    /**
     * Создает и обрабатывает запрос к серверу
     * @todo разобраться с cookies
     * @param mixed  $uri URI запроса
     * @param mixed  $method Метод запроса
     * @param mixed  $get Массив данных для переменной $_GET
     * @param mixed  $post Массив данных для переменной $_POST
     * @param mixed  $server Массив данных для переменной $_SERVER
     * @param mixed  $files Массив данных для переменной $_FILES
     * @return \Neiron\Kernel\Request\ControllerResolver
     */
    public function create(
        $uri = null, 
        $method = null, 
        $get = null, $post = null, 
        $server = null, 
        $files = null
    ){
        $this->get($get);
        $this->post($post);
        $this->server($server);
        $this->globals($files, null, '_FILES');
        return $this->resolver->resolve(
                $this->container['routing']->match(
                        $this->decodeDetectUri($uri), $this->method($method)
                ), $this->container
        );
    }
    /**
     * Возвращает или определяет и декодирует строку uri
     * @param mixed $uri URI строка
     * @return string  Декодированная строка
     */
    private function decodeDetectUri($uri = null)
    {
        if ($uri === null) {
            if (!empty($this->server('PATH_INFO'))) {
                $uri = $this->server('PATH_INFO');
            } elseif (!empty($this->server('REQUEST_URI'))) {
                $uri = $this->server('REQUEST_URI');
            }
        }
        return $this->uri(rawurldecode(rtrim($uri, '/')));
    }
    /**
     * Задает/выдает (если есть) адрес страницы, которая привела браузер пользователя на эту страницу
     * @param string $refer Адрес страницы
     * @return mixed Если есть (или указан) адрес страницы то выдает его или возвращает false
     */
    public function referer($refer = null)
    {
        if ($refer != null) {
            $this->server('HTTP_REFERER', $refer);
        }
        if ($this->server('HTTP_REFERER') !== null) {
            return $this->server('HTTP_REFERER');
        }
        return false;
    }
    /**
     * Сохраняет/выводит данные пременной $GLOBALS
     * @param mixed $name Имя переменной
     * @param mixed $value Значение переменной
     * @param mixed $var Индех переменной
     * @return mixed
     */
    public function globals($name = null, $value = null, $var = false)
    {
        $glob = $var ? $this->globals[$var] : $this->globals;
        // Слияние массивов с заменой
        if (is_array($name)) {
            return $this->globals = array_merge($glob, $name);
        }
        // Передача всего содержимого
        if ($name === null && $value === null) {
            return $glob;
        }
        // Проверка на наличие и передача переменной из массива
        if ($name !== null && $value === null) {
            if (array_key_exists($name, $glob)) {
                return $glob[$name];
            }
            return false;
        }
        // Запись переменной
        if ($name !== null && $value !== null) {
            return $glob[$name] = $value;
        }
    }
    /**
     * Сохраняет/выводит метод запроса
     * @param mixed $method Метод запроса
     * @return string Метод запроса
     */
    public function method($method = null)
    {
        if ($method !== null) {
            $this->server('REQUEST_METHOD', $method);
        }
        return $this->server('REQUEST_METHOD');
    }
    /**
     * Сохраняет/выводит URI запроса
     * @param mixed $uri URI запроса
     * @return string URI запроса
     */
    public function uri($uri = null)
    {
        return isset($uri) ? $this->uri = $uri : $this->uri;
    }
    /**
     * Сохраняет/выводит данные пременной $_SERVER
     * @param mixed $name Имя переменной
     * @param mixed $value Значение переменной
     * @return mixed
     */
    public function server($name = null, $value = null)
    {
        return $this->globals($name, $value, '_SERVER');
    }
    /**
     * Сохраняет/выводит данные пременной $_GET
     * @param mixed $name Имя переменной
     * @param mixed $value Значение переменной
     * @return mixed
     */
    public function get($name = null, $value = null)
    {
        return $this->globals($name, $value, '_GET');
    }
    /**
     * Сохраняет/выводит данные пременной $_POST
     * @param mixed $name Имя переменной
     * @param mixed $value Значение переменной
     * @return mixed
     */
    public function post($name = null, $value = null)
    {
        return $this->globals($name, $value, '_POST');
    }
    /**
     * Сохраняет/выводит данные пременной $_FILES
     * @param mixed $name Имя переменной
     * @param mixed $value Значение переменной
     * @return mixed
     */
    public function files($name = null, $value = null)
    {
        return $this->globals($name, $value, '_FILES');
    }
}