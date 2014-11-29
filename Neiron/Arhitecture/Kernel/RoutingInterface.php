<?php

namespace Neiron\Arhitecture\Kernel;

/**
 *
 * @author KpuTuK
 */
interface RoutingInterface
{
    public function addRoute($name, $pattern, $method);
    public function addRoutes(array $routes = array());
    public function match($uri = null, $method = RequestInterface::METH_GET);
}