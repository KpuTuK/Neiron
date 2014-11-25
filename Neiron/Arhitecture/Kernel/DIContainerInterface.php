<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Arhitecture\Kernel;
/**
 * Класс для реализации Dependicy Inection контейнера
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
interface DIContainerInterface extends \ArrayAccess {
    /**
     * 
     * @param type $name
     * @param type $class
     */
    public function setInstance($name, $class);
    /**
     * 
     * @param type $name
     * @param type $value
     */
    public function rewind($name, $value);
}
