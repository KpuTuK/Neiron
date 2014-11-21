<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Arhitecture\Kernel;

/**
 *
 * @author KpuTuK
 */
interface ApplicationInterface extends \ArrayAccess  {
    public function get($name, $pattern, $handler);
    public function post($name, $pattern, $handler);
    public function put($name, $pattern, $handler);
    public function delete($name, $pattern, $handler);
}
