<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Arhitecture\Kernel\Response;
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
     * Удаляет/добавляет/выводит заголовки
     * @param mixed $name Массив заголовков или имя заголовка
     * @param string $value Содержимое заголовка
     * @return mixed
     */
    public function headers($name = null, $value = null);
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
