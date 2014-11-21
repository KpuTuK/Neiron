<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Neiron\Arhitecture;

/**
 *
 * @author KpuTuK
 */
interface ApplicationInterface extends \ArrayAccess  {
    public function get($pattern, $handler);
    public function post($pattern, $handler);
    public function put($pattern, $handler);
    public function delete($pattern, $handler);
}
