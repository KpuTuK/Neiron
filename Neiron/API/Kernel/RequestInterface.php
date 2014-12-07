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
}
