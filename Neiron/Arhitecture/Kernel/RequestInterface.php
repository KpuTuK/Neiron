<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Arhitecture\Kernel;
/**
 * Интерфейс для реалиации обработчика запросов к серверу
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
interface RequestInterface {
    /**
     * Метод запроса GET
     */
    const METH_GET = 'GET';
    /**
     * Метод запроса POST
     */
    const METH_POST = 'POST';
    /**
     * Метод запроса PUT
     */
    const METH_PUT = 'PUT';
    /**
     * Метод запроса DELETE
     */
    const METH_DELETE = 'DELETE';
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
            $get = null,
            $post = null,
            $server = null,
            $files = null
    ) ;
    /**
     * Задает/выдает (если есть) адрес страницы, которая привела браузер пользователя на эту страницу
     * @param string $refer Адрес страницы
     * @return mixed Если есть (или указан) адрес страницы то выдает его или возвращает false
     */
    public function referer($refer = null);
    /**
     * Сохраняет/выводит данные пременной $GLOBALS
     * @param mixed $name Имя переменной
     * @param mixed $value Значение переменной
     * @param mixed $var Индех переменной
     * @return mixed
     */
    public function globals($name = null, $value = null, $var = false);
    /**
     * Сохраняет/выводит метод запроса
     * @param mixed $method Метод запроса
     * @return string Метод запроса
     */
    public function method($method = null);
    /**
     * Сохраняет/выводит URI запроса
     * @param mixed $uri URI запроса
     * @return string URI запроса
     */
    public function uri($uri = null);
    /**
     * Сохраняет/выводит данные пременной $_SERVER
     * @param mixed $name Имя переменной
     * @param mixed $value Значение переменной
     * @return mixed
     */
    public function server($name = null, $value = null);
    /**
     * Сохраняет/выводит данные пременной $_GET
     * @param mixed $name Имя переменной
     * @param mixed $value Значение переменной
     * @return mixed
     */
    public function get($name = null, $value = null);
    /**
     * Сохраняет/выводит данные пременной $_POST
     * @param mixed $name Имя переменной
     * @param mixed $value Значение переменной
     * @return mixed
     */
    public function post($name = null, $value = null);
    /**
     * Сохраняет/выводит данные пременной $_FILES
     * @param mixed $name Имя переменной
     * @param mixed $value Значение переменной
     * @return mixed
     */
    public function files($name = null, $value = null);
}
