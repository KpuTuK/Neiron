<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Request;

use Neiron\API\Kernel\DIContainerInterface;
use Neiron\API\Kernel\Request\ControllerResolverInterface;

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
    protected $options;
    /**
     * Dependency injection контейнер
     * @var \Neiron\API\Kernel\DIContainerInterface
     */
    protected $container;
    /**
     * Обрабатывает параметры
     * @param array $options Массив параметров контроллера
     * @param \Neiron\APIe\Kernel\DIContainerInterface $container Dependency injection контейнер
     * @throws \InvalidArgumentException Исключение выбрасываемое в случае ошибки валидации параметров
     * @return \Neiron\API\Kernel\Request\ControllerResolverInterface
     */
    public function resolve(array $options, DIContainerInterface $container)
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
        return $this;
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
    protected function getControllerString()
    {
        list($class, $action) = explode('@', $this->options['handler']);
            if (!class_exists($class)) {
                return (new \Neiron\Kernel\Controller($this->container))
                        ->pageNotFound($class .'/'. $action);
            }
            $obj = new $class($this->container);
            if ( ! $obj instanceof \Neiron\Kernel\Controller) {
                throw new \ErrorException(
                    'Контроллер должен наследовать класс "\Neiron\Kernel\Controller"!'
                );
            }
            if (!method_exists($obj, $action)) {
                $action = 'pageNotFound';
                $this->options['params'] = $class .'/'. $action;
            }
            $obj->atfer();
            $response = $obj->$action($this->options['params']);
            $obj->beforle();
            return $response;
    }
}