<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;

use Neiron\API\Kernel\ControllerInterface;
use Neiron\API\Kernel\DIContainerInterface;

/**
 * Главный контроллер
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Controller implements ControllerInterface
{
    /**
     * Dependency injection контейнер
     * @var \Neiron\API\Kernel\DIContainerInterface
     */
    protected $container;
    /**
     * Обработчик запросов
     * @var \Neiron\API\Kernel\RequestInterface
     */
    protected $request;
    /**
     * Класс для работы с выводом
     * @var \Neiron\API\Kernel\ResponseInterface 
     */
    protected $response;
    /**
     * Обработчик роутов
     * @var \Neiron\API\Kernel\RoutingInterface
     */
    protected $routing;
    /**
     * Конструктор класса
     * @param \Neiron\API\Kernel\DIContainerInterface $container Dependency injection контейнер
     */
    public function __construct(DIContainerInterface $container)
    {
        $this->container = $container;
        $this->request = $container['request'];
        $this->response = $container['response'];
        $this->routing = $container['routing'];
    }
    /**
     * Выдает сообщение об ошибке 404
     */
    public function pageNotFound($url = '')
    {
        $this->response->headers(array(
            $this->request->server['SERVER_PROTOCOL'] => '404 Not Found',
            'Status:' => '404 Not Found',
            'Refresh:' =>  '3; url=/'
        ));
        $this->response->setContent('
            <h1>Не найдено!</h1>
            <hr>
            Запрашиваемый адрес "'. $url .'" не найден на сервере!
        ');
    }
    /**
     * Функция вызываемая перед вызовом экшена контроллера
     */
    public function atfer()
    {
        
    }
    /**
     * Функция вызываемая после вызова экшена контроллера
     */
    public function beforle()
    {
        
    }
}