<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Neiron\Kernel\Request;

use Neiron\Kernel\Helpers\ParameterManager;
use Neiron\API\Kernel\RequestInterface;
/**
 * Description of GlobalsManager
 *
 * @author KpuTuK
 */
class GlobalsManager extends ParameterManager
{
    public function __construct(array $parameters)
    {
        if (empty($parameters['_SERVER']['REQUEST_METHOD'])) {
            $parameters['_SERVER']['REQUEST_METHOD'] = RequestInterface::METH_GET;
        }
        if ( ! isset($parameters['_FILES'])) {
            $parameters['_FILES'] = array();
        }
        if ( ! isset($parameters['_COOKIE'])){
            $parameters['_COOKIE'] = array();
        }
        parent::__construct($parameters);
    }
}