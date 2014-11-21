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
interface RequestInterface {
    const METH_GET = 'GET';
    const METH_POST = 'POST';
    const METH_PUT = 'PUT';
    const METH_DELETE = 'DELETE';
}
