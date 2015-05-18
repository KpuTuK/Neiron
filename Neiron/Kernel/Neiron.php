<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;

use Neiron\API\Kernel\ApplicationInterface;
use Neiron\API\Kernel\RequestInterface;
use Neiron\Kernel\DIContainer;
use Neiron\Kernel\Response\ResponseHeaders;
use Neiron\API\Kernel\DIContainerInterface;

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
    const VERSION = '0.0.1-alpha';
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
        $this['routing'] = new Routing($this['routes']);
        $this['controller.resolver'] = new Request\ControllerResolver();
        $this['request'] = new Request($this, $this['controller.resolver']);
        $this['response.headers'] = new ResponseHeaders(
            array(), 
            $this['request']
        );
        $this['response'] = new Response($this['response.headers']);
    }
    /**
     * Настраивает значения по умолчанию для настроек
     * @param array $options Массив настроек
     */
    protected function setup(array $options = array())
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
        $this['routing']->addRoute(
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
        $this['routing']->addRoute(
                $name, $pattern, $handler, RequestInterface::METH_DELETE
        );
    }
    /**
     * Запускает приложение
     */
    public function run()
    {
        echo $this['request']->create(null)->execute()->body();
    }
}