<?php
 namespace Neiron\Kernel;

use Neiron\Arhitecture\Kernel\RoutingInterface;
use Neiron\Arhitecture\Kernel\RequestInterface;

class Routing implements RoutingInterface
{
    /**
     * Массив роутов
     * @var array 
     */
    private $routes = array();
    /**
     * Массив паттернов и обработчиков
     * @var array
     */
    private $patterns = array();
    /**
     * Добавляет обработчик роута по паттерну
     * @param string $name Имя роута
     * @param string $pattern Паттерн обработки uri
     * @param mixed $handler Путь к контроллеру или анонимная функция 
     * @param string $method Метод запроса
     */
    public function addRoute($name, $pattern, $handler, $method = RequestInterface::METH_GET)
    {
        $regex = $this->compilePattern(rtrim($pattern, '/'));
        $this->routes[$method][$name] = array(
            'handler' => $handler,
            'pattern' => $regex
        );
        $this->patterns[$method][$regex] = $handler;
    }
    private function compilePattern($pattern)
    {
        if (false === strpos($pattern, '{')) {
            return $pattern;
        }
        return preg_replace_callback('#\{(\w+):(\w+)\}#', function ($match) {
            $patterns = array(
                'i' => '[0-9]+',
                's' => '[a-zA-Z\.\-_%]+',
                'x' => '[a-zA-Z0-9\.\-_%]+',
            );
            list(, $name, $prce) = $match;
            return '(?<' . $name . '>' . strtr($prce, $patterns) . ')';
        }, $pattern);
    }
    public function addRoutes(array $routes = array())
    {
        foreach ($routes as $route) {
            $this->addRoute(
                    $route['name'], $route['pattern'], $route['handler'], $route['method']
            );
        }
    }
    public function match($uri = null, $method = RequestInterface::METH_GET)
    {
        if (array_key_exists($uri, $this->patterns[$method])) {
            return array(
                'handler' => $this->patterns[$method][$uri],
                'params' => array()
            );
        }
        $matches = array();
        foreach ($this->routes[$method] as $route) {
            if (preg_match('#^' . $route['pattern'] . '$#s', $uri, $matches)) {
                return array(
                    'handler' => $route['handler'],
                    'params' => $this->getParams($matches)
                );
            }
        }
        return array();
    }
    private function getParams($params)
    {
        foreach ($params as $key => $value) {
            if (is_int($key)) {
                unset($params[$key]);
            }
        }
        return $params;
    }
}