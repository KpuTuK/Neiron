<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Neiron\Kernel\Request;

use Neiron\Kernel\Helpers\ParameterManager;
/**
 * Description of CookieManager
 *
 * @author KpuTuK
 */
class CookieManager extends ParameterManager
{
    private $fromHeader = array();
    public function set(
        $name,
        $value, 
        $ttl = 1,
        $path = '/',
        $domain = null,
        $secure = false,
        $httpOnly = true
    ){
        $this->fromHeader[] = array(
            'name' => $name,
            'value' => $value,
            'ttl' => time() + ($ttl * 3600),
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httpOnly' => $httpOnly
        );
        $this->parameters[$name] = $value;
    }
    public function offsetSet($offset, $value)
    {
        $data = array_replace(array(
            'value' => null,
            'ttl' => 1,
            'path' => '/',
            'domain' => null,
            'secure' => false,
            'httpOnly' => true
        ), $value);
        $this->set(
            $offset,
            $data['value'],
            $data['ttl'], 
            $data['path'],
            $data['domain'],
            $data['secure'],
            $data['httpOnly']
        );
    }
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $this->set($offset, '', -24 * 3600);
        }
        parent::offsetUnset($offset);
    }
    public function getFromHeader()
    {
        return $this->fromHeader;
    }
}