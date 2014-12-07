<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Neiron\Kernel\Request;

use Neiron\Kernel\Helpers\ParameterManager;

/**
 * Description of HeaderManager
 *
 * @author KpuTuK
 */
class HeaderManager extends ParameterManager
{
    public function __construct(array $server)
    {
        foreach ($server as $key => $value) {
            if (strpos($key, 'HTTP_') !== false) {
                $list[substr(strtr($key, '_', '-'), 5)] = $value;
            }
        }
        parent::__construct($list);
    }
}