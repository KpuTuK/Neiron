<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Arhitecture\Kernel;

/**
 * Обработчик роутов
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
interface RoutingInterface
{
    /**
     * Добавляет роут в обработчик
     * @param string $name Имя роута
     * @param string $pattern Паттерн обработки
     * @param mixed $handler Анонимная функция или строка вида "пространство имен контроллера@экшен"
     * @param string $method Метод запроса
     */
    public function addRoute($name, $pattern, $handler, $method = RequestInterface::METH_GET);
    /**
     * Добавляет массив роутов в обработчик
     * @param array $routes Массив роутов
     */
    public function addRoutes(array $routes = array());
    /**
     * Обрабатывает uri по роуту
     * @param string $uri Обрабатываемый uri
     * @param string $method Метод запроса
     */
    public function match($uri = null, $method = RequestInterface::METH_GET);
}