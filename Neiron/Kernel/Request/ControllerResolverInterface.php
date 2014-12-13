<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Request;

/**
 * Интерфейс для реализации пределителя контроллеров
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
interface ControllerResolverInterface
{
    /**
     * Обрабатывает параметры
     * @param array $options Массив параметров контроллера
     * @param \Neiron\Kernel\DIContainer $container Dependency injection контейнер
     * @throws \InvalidArgumentException Исключение выбрасываемое в случае ошибки валидации параметров
     * @return \Neiron\Kernel\Request\ControllerResolver
     */
    public function resolve(array $options, DIContainer $container);
    /**
     * Выполняет контроллер
     * @return \Neiron\Kernel\Response\ResponseInterface
     * @throws \ErrorException 
     */
    public function execute();
}