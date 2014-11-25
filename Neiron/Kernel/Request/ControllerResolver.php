<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Request;
use Neiron\Arhitecture\Kernel\ApplicationInterface;
/**
 * Определитель контроллеров
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class ControllerResolver {
    /**
     * Массив параметров контроллера
     * @var array 
     */
    private $options;
    /**
     * Dipendicy Inection контейнер
     * @var \Neiron\Arhitecture\Kernel\ApplicationInterface
     */
    private $container;
    /**
     * Конструктор класса
     * @param array $options Массив параметров контроллера
     * @param \Neiron\Arhitecture\Kernel\ApplicationInterface $container Dipendicy Inection контейнер
     * @throws \InvalidArgumentException Исключение выбрасываемое в случае ошибки валидации параметров
     */
    public function __construct(array $options, ApplicationInterface $container) {
        if ( ! is_string($options['handler']) && ! is_object($options['handler'])) {
            throw new \InvalidArgumentException(sprintf(
                'Параметр "handler" должен быть "string|object" вместо "%s"!',
                gettype($options['handler']))
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
    public function execute() {
        if (is_string($this->options['handler'])) {
            list($class, $action) = explode('@', $this->options['handler']);
            $obj = new $class($this->container);
            if ($obj instanceof \Neiron\Arhitecture\Kernel\ControllerInterface) {
                throw new \ErrorException(
                    'Контроллер должен реализовать интерфейс "\Neiron\Arhitecture\Kernel\ControllerInterface"!'
                );
            }
            $obj->atfer();
            $response = $obj->$action($this->options['params']);
            $obj->beforle();
        } else {
            $this->options['params']['dic'] = $this->container;
            $response = $this->options['handler']($this->options['params']);
        }
        return $this->container['response']->setContent($response);
    }
}
