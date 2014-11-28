<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;
use Neiron\Arhitecture\Kernel\ControllerInterface;
use Neiron\Arhitecture\Kernel\DIContainerInterface;
/**
 * Главный контроллер
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Controller implements ControllerInterface {
    /**
     * Dependency injection контейнер
     * @var \Neiron\Arhitecture\Kernel\DIContainerInterface
     */
    protected $container;
    /**
     * Обработчик запросов
     * @var \Neiron\Arhitecture\Kernel\RequestInterface
     */
    protected $request;
    /**
     * Класс для работы с выводом
     * @var \Neiron\Arhitecture\Kernel\ResponseInterface 
     */
    protected $response;
    /**
     * Обработчик роутов
     * @var \Neiron\Arhitecture\Kernel\RoutingInterface
     */
    protected $routing;
    /**
     * Конструктор класса
     * @param \Neiron\Arhitecture\Kernel\DIContainerInterface $container Dependency injection контейнер
     */
    public function __construct(DIContainerInterface $container) {
        $this->container = $container;
        $this->request = $container['request'];
        $this->response = $container['response'];
        $this->routing = $container['routing'];
    }
    /**
     * Функция вызываемая перед вызовом экшена контроллера
     */
    public function atfer();
    /**
     * Функция вызываемая после вызова экшена контроллера
     */
    public function beforle();
}
