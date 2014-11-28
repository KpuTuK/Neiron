<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Arhitecture\Kernel;
/**
 * Класс для реализации Dependency injection контейнера
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
interface DIContainerInterface extends \ArrayAccess {
    /**
     * Создает функцию при вызове которой каждый раз будет вызван конструктор класса
     * @param string $name Имя функции
     * @param mixed $class Пространство имен или обьект класса
     */
    public function setInstance($name, $class);
    /**
     * Меняет содержимое в контейнере по ключу
     * @param string $name
     * @param mixed $value
     */
    public function rewind($name, $value);
}
