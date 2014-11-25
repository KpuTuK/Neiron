<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Arhitecture\Kernel;
/**
 * Интерфейс реализации класса для работы с выводом
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
interface ResponseInterface {
    /**
     * Сохраняет выводит заголовки
     * @param mixed $name Массив заголовков или ключ заголовка
     * @param string $value Содержимое заголовка
     * @return mixed
     */
    public function headers($name = null, $value = null);
    /**
     * Сохраняет содержимое вывода
     * @param string $content Строковое представение вывода
     * @return \Neiron\Kernel\Response
     */
    public function setContent($content);
    /**
     * Сохраняет заголовки и возвращает строковое представение вывода
     * @return string Строковое представение вывода
     */
    public function body();
}
