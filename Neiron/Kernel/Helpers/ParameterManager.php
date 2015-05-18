<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel\Helpers;

/**
 * Менеджер параметров
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class ParameterManager extends \ArrayObject
{
    public function merge(array $params) 
    {
        return $this->exchangeArray(array_merge((array)$this->getArrayCopy(), $params));
    }
}