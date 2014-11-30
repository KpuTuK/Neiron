<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;

use Neiron\Arhitecture\Kernel\ApplicationInterface;
use Neiron\Arhitecture\Kernel\RequestInterface;
use Neiron\Kernel\DIContainer;
use Neiron\Arhitecture\Kernel\DIContainerInterface;

/**
 * Базовый класс framework'a
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Neiron extends DIContainer implements ApplicationInterface, 
    DIContainerInterface
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
    public $container;
    /**
     * Конструктор класса
     * @param array $options Массив настроек (опционально)
     */
    public function __construct(array $options = array())
    {
        parent::__construct($this->setup($options));
        $this['routing'] = new Routing();
        $this['routing']->addRoutes($this['routes']);
        $this['request'] = new Request($this);
        $this['response'] = new Response($this['request']);
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
        $this['routing']->addRoute(
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
        $this['routing']->addRoute(
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
        $this['routing']->addRoute(
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
        $this['routing']->addRoute(
                $name, $pattern, $handler, RequestInterface::METH_GET
        );
    }
    /**
     * Запускает приложение
     */
    public function run()
    {
        echo $this['request']->create()->execute()->body();
    }
}