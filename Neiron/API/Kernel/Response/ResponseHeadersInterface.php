<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\API\Kernel\Response;
/**
 * Интерфейс для реализации класса для управления заголовками вывода
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
interface ResponseHeadersInterface 
{
    /**
     * Отпраляет заголовки если они еще не были отправлены
     * @return 
     */
    public function sendHeaders();
    /**
     * Выводит массив кодировок
     * @return array
     */
    public function getEncodings();
    /**
     * Выводит Accept заголовки
     * @return array
     */
    public function getAccepts();
    /**
     * Выводит массив языков
     * @return array
     */
    public function getLanguages();
}
