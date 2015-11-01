<?php

/**
 * PHP 5.4 framework с открытым иходным кодом
 */

namespace Neiron\Components\Http;

/**
 * Интерфейс определяющй константы метода запроса
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Http
 */
interface RequestMethodInterface {
    const METH_HEAD = 'HEAD';
    const METH_GET = 'GET';
    const METH_POST = 'POST';
    const METH_PUT = 'PUT';
    const METH_PATCH = 'PATCH';
    const METH_DELETE = 'DELETE';
    const METH_PURGE = 'PURGE';
    const METH_OPTIONS = 'OPTIONS';
    const METH_TRACE = 'TRACE';
    const METH_CONNECT = 'CONNECT';
}
