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
     * @var \Neiron\API\Kernel\Request\ControllerResolverInterface
     */
    private $resolver;
    /**
     * Обработчик-альтернатива суперглобальной переменной $GLOBALS
     * @var \Neiron\Kernel\Request\ParameterManager
     */
    public $globals;
    /**
     * Обработчик-альтернатива глобальной переменной $_SERVER
     * @var \Neiron\Kernel\Request\ParameterManager
     */
    public $server;
    /**
     * Обработчик-альтернатива глобальной переменной $_GET
     * @var \Neiron\Kernel\Request\ParameterManager
     */
    public $query;
    /**
     * Обработчик-альтернатива глобальной переменной $_POST
     * @var \Neiron\Kernel\Request\ParameterManager
     */
    public $post;
    /**
     * Обработчик-альтернатива глобальной переменной $_FILES
     * @var \Neiron\Kernel\Request\ParameterManager
     */
    public $files;
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
        /**
         * @todo !!!!!!!
         */
        $this->cookies = $container['cookie'];
        $this->resolver = $resolver;
    }
    /**
     * Заполняет глобальные переменные
     * @return \Neiron\API\Kernel\RequestInterface
     */
    public function initalGlobals()
    {
        $this->globals = new Request\ParameterManager($GLOBALS);
        if ( ! isset($this->globals['_FILES'])) {
            $this->globals['_FILES'] = array();
        }
        $this->server = new Request\ParameterManager($this->globals['_SERVER']);
        if (empty($this->server['REQUEST_METHOD'])) {
            $this->server['REQUEST_METHOD'] = self::METH_GET;
        }
        $this->query = new Request\ParameterManager($this->globals['_GET']);
        $this->post = new Request\ParameterManager($this->globals['_POST']);
        $this->files = new Request\ParameterManager($this->globals['_FILES']);
        return $this;
    }
    /**
     * Создает и обрабатывает запрос к серверу
     * @todo разобраться с cookies
     * @param string  $uri URI запроса
     * @param mixed  $method Метод запроса
     * @param array  $server Массив данных для переменной $_SERVER
     * @param array  $query Массив данных для переменной $_GET
     * @param array  $post Массив данных для переменной $_POST
     * @param array  $files Массив данных для переменной $_FILES
     * @return \Neiron\API\Kernel\Request\ControllerResolverInterface
     */
    public function create(
        $uri, 
        $method = null,
        array $server = array(),
        array $query = array(), 
        array $post = array(),  
        array $files = array()
    ){
        $this->server->merge($server);
        $this->query->merge($query);
        $this->post->merge($post);
        $this->files->merge($files);
        return $this->resolver->resolve(
            $this->container['routing']->match(
                $this->decodeDetectUri($uri),
                empty($method) ? $this->server['REQUEST_METHOD'] : $method
            ), 
            $this->container
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
            if (!empty($this->server['PATH_INFO'])) {
                $uri = $this->server['PATH_INFO'];
            } elseif (!empty($this->server['REQUEST_URI'])) {
                $uri = explode('?', $this->server['REQUEST_URI'])[0];
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
            $this->server['HTTP_REFERER'] = $refer;
        }
        if ($this->server['HTTP_REFERER'] !== null) {
            return $this->server['HTTP_REFERER'];
        }
        return false;
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
}