<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;

/**
 * Главный контроллер
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Controller
{
    /**
     * Dependency injection контейнер
     * @var \Neiron\Kernel\DIContainer
     */
    protected $container;
    /**
     * Обработчик запросов
     * @var \Neiron\Kernel\Request
     */
    protected $request;
    /**
     * Класс для работы с выводом
     * @var \Neiron\Kernel\Response 
     */
    protected $response;
    /**
     * Обработчик роутов
     * @var \Neiron\Kernel\Routing
     */
    protected $routing;
    /**
     * Конструктор класса
     * @param \Neiron\Kernel\DIContainer $container Dependency injection контейнер
     */
    public function __construct(DIContainer $container)
    {
        $this->container = $container;
        $this->request = $container['request'];
        $this->response = $container['response'];
        $this->routing = $container['routing'];
    }
}