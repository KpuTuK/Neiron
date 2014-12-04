<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\API\Kernel;
/**
 * Интерфейс для реалиации обработчика запросов к серверу
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
interface RequestInterface 
{
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
     * Создает и обрабатывает запрос к серверу заполняя глобальные переменные
     * @return \Neiron\API\Kernel\Request\ControllerResolverInterface
     */
    public function createFromGlobals();
    /**
     * Создает и обрабатывает запрос к серверу
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
    ) ;
    /**
     * Задает/выдает (если есть) адрес страницы, которая привела браузер пользователя на эту страницу
     * @param string $refer Адрес страницы
     * @return mixed Если есть (или указан) адрес страницы то выдает его или возвращает false
     */
    public function referer($refer = null);
    /**
     * Сохраняет/выводит URI запроса
     * @param mixed $uri URI запроса
     * @return string URI запроса
     */
    public function uri($uri = null);
}
