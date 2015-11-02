<?php
/**
     * PHP 5x framework с открытым иходным кодом
     */
namespace Neiron\Kernel;

/**
 * Базовый класс framework'a
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Neiron extends DependencyInjection implements \ArrayAccess
{
    /**
     * Версия frameworka
     */
    const VERSION = '0.0.1-alpha';
    /**
     * Конструктор класса
     * @param array $options Массив настроек (опционально)
     */
    public function __construct(array $options = [])
    {
        
    }
    /**
     * Добавляет обработчик роута по паттерну вызываемого методом GET
     * @param sring $name Имя роута
     * @param string $pattern Паттерн обработки роута
     * @param mixed $handler Обработчик роута
     */
    public function get($name, $pattern, $handler)
    {
        $this['routing']->withRoute(
            $name, $pattern, $handler, RequestInterface::METH_GET
        );
    }
    /**
     * Добавляет обработчик роута по паттерну вызываемого методом POST
     * @param sring $name Имя роута
     * @param string $pattern Паттерн обработки роута
     * @param mixed $handler Обработчик роута
     */
    public function post($name, $pattern, $handler)
    {
        $this['routing']->withRoute(
            $name, $pattern, $handler, RequestInterface::METH_POST
        );
    }
    /**
     * Добавляет обработчик роута по паттерну вызываемого методом PUT
     * @param sring $name Имя роута
     * @param string $pattern Паттерн обработки роута
     * @param mixed $handler Обработчик роута
     */
    public function put($name, $pattern, $handler)
    {
        $this['routing']->withRoute(
                $name, $pattern, $handler, RequestInterface::METH_PUT
        );
    }
    /**
     * Добавляет обработчик роута по паттерну вызываемого методом PUT
     * @param sring $name Имя роута
     * @param string $pattern Паттерн обработки роута
     * @param mixed $handler Обработчик роута
     */
    public function delete($name, $pattern, $handler)
    {
        $this['routing']->withRoute(
                $name, $pattern, $handler, RequestInterface::METH_DELETE
        );
    }
    /**
     * Запускает приложение
     */
    public function run()
    {
        
    }
}