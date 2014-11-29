<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;

use Neiron\Arhitecture\Kernel\ApplicationInterface;
use Neiron\Arhitecture\Kernel\RequestInterface;
use Neiron\Kernel\DIContainer;

/**
 * Базовый класс framework'a
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Neiron implements ApplicationInterface
{
    /**
     * Версия frameworka
     */
    const VERSION = '1.0.0';
    /**
     * Весрсия согласно дате релиза с пометками beta|stable
     */
    const DAYVERSION = '28.11.14 beta';
    /**
     * Dependicy Inection контейнер
     * @var array
     */
    private $container;
    /**
     * Конструктор класса
     * @param array $options Массив настроек (опционально)
     */
    public function __construct(array $options = array())
    {
        $this->container = new DIContainer($this->setup($options));
        $this->container['routing'] = new Routing();
        $this->container['routing']->addRoutes($this->container['routes']);
        $this->container['request'] = new Request($this->container);
        $this->container['response'] = new Response($this->container['request']);
        $this = $this->container;
    }
    /**
     * Настраивает значения по умолчанию для настроек
     * @param array $options Массив настроек
     */
    private function setup(array $options = array())
    {
        if (!isset($options['routes'])) {
            $options['routes'] = array();
        }
        return $options;
    }
    /**
     * Добавляет обработчик роута по паттерну вызываемого методом GET
     * @param sring $name Имя роута
     * @param string $pattern Паттерн обработки роута
     * @param mixed $handler Обработчик роута
     */
    public function get($name, $pattern, $handler)
    {
        $this->container['routing']->addRoute(
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
        $this->container['routing']->addRoute(
                $name, $pattern, $handler, RequestInterface::METH_GET
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
        $this->container['routing']->addRoute(
                $name, $pattern, $handler, RequestInterface::METH_GET
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
        $this->container['routing']->addRoute(
                $name, $pattern, $handler, RequestInterface::METH_GET
        );
    }
    /**
     * Запускает приложение
     */
    public function run()
    {
        echo $this->container['request']->create()->execute()->body();
    }
}