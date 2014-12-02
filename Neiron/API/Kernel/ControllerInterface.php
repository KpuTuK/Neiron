<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\API\Kernel;

/**
 * Главный контроллер
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
interface ControllerInterface
{
    /**
     * Функция вызываемая перед вызовом экшена контроллера
     */
    public function atfer();
    /**
     * Функция вызываемая после вызовоа экшена контроллера
     */
    public function beforle();
    /**
     * Сообщение об ошибке 404
     */
    public function pageNotFound();
}