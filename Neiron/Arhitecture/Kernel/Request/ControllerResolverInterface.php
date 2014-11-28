<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Arhitecture\Kernel\Request;
/**
 * Определитель контроллеров
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
interface ControllerResolverInterface {
        /**
     * Выполняет контроллер
     * @return \Neiron\Arhitecture\Kernel\ResponseInterface
     * @throws \ErrorException 
     */
    public function execute();
}
