<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Request;

use Neiron\Arhitecture\Kernel\DIContainerInterface;
use Neiron\Arhitecture\Kernel\Request\ControllerResolverInterface;

/**
 * Определитель контроллеров
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class ControllerResolver implements ControllerResolverInterface
{
    /**
     * Массив параметров контроллера
     * @var array 
     */
    private $options;
    /**
     * Dependency injection контейнер
     * @var \Neiron\Arhitecture\Kernel\DIContainerInterface
     */
    private $container;
    /**
     * Конструктор класса
     * @param array $options Массив параметров контроллера
     * @param \Neiron\Arhitecture\Kernel\DIContainerInterface $container Dependency injection контейнер
     * @throws \InvalidArgumentException Исключение выбрасываемое в случае ошибки валидации параметров
     */
    public function __construct(array $options, DIContainerInterface $container)
    {
        if (!is_string($options['handler']) && !is_object($options['handler'])) {
            throw new \InvalidArgumentException(sprintf(
                    'Параметр "handler" должен быть "string|object" вместо "%s"!', gettype($options['handler']))
            );
        }
        if (is_string($options['handler'])) {
            if (strpos($options['handler'], '@') === false) {
                throw new \InvalidArgumentException(
                'Параметр "handler" должен быть вида "controllerNamespace@action"!'
                );
            }
        }
        $this->options = $options;
        $this->container = $container;
    }
    /**
     * Выполняет контроллер
     * @return \Neiron\Arhitecture\Kernel\ResponseInterface
     * @throws \ErrorException 
     */
    public function execute()
    {
        if (is_string($this->options['handler'])) {
            $response = $this->getControllerString();
            // Если конроллер анонимная функция
        } else {
            $this->options['params']['dic'] = $this->container;
            $response = $this->options['handler']($this->options['params']);
        }
        return $this->container['response']->setContent($response);
    }
    /**
     * Обрабатывает контроллер вида namespace@action
     * @return string Строковое представление контента
     * @throws \ErrorException
     */
    private function getControllerString()
    {
        list($class, $action) = explode('@', $this->options['handler']);
            if (!class_exists($class)) {
                return (new \Neiron\Kernel\Controller($this->container))
                        ->pageNotFound();
            }
            $obj = new $class($this->container);
            if ( ! $obj instanceof \Neiron\Arhitecture\Kernel\ControllerInterface) {
                throw new \ErrorException(
                'Контроллер должен реализовать интерфейс "\Neiron\Arhitecture\Kernel\ControllerInterface"!'
                );
            }
            if (!method_exists($obj, $action)) {
                return (new \Neiron\Kernel\Controller($this->container))
                        ->pageNotFound();
            }
            $obj->atfer();
            $response = $obj->$action($this->options['params']);
            $obj->beforle();
            return $response;
    }
}