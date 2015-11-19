<?php
/**
     * PHP 5x framework с открытым иходным кодом
     */

namespace Neiron\Kernel;


/**
 * Обработчик роутов
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Routing
{
    /**
     * Массив роутов
     * @var array 
     */
    protected $routes = [
        'GET' => [], 'POST' => [], 'PUT' => [], 'DELET' => []
    ];
    /**
     * Массив паттернов и обработчиков
     * @var array
     */
    protected $patterns = [
        'GET' => [], 'POST' => [], 'PUT' => [], 'DELET' => []
    ];
    /**
     * Конструктор класса
     * @param array $routes Массив роутов
     */
    public function __construct(array $routes = [])
    {
        $this->withRoutes($routes);
    }
    /**
     * Добавляет роут в обработчик
     * @param string $name Имя роута
     * @param string $pattern Паттерн обработки
     * @param mixed $handler Анонимная функция или строка вида "пространство имен контроллера@экшен"
     * @param string $method Метод запроса
     */
    public function withRoute($name, $pattern, $handler, $method = RequestInterface::METH_GET)
    {
        $regex = $this->compilePattern(rtrim($pattern, '/'));
        $this->routes[$method][$name] = [
            'handler' => $handler,
            'pattern' => $regex
        ];
        $this->patterns[$method][$regex] = $handler;
    }
    /**
     * Компилирует паттерн из условного выражения
     * @param string $pattern Компилируемый паттерн
     * @return string Скомпилированный паттерн
     */
    protected function compilePattern($pattern)
    {
        if (false === strpos($pattern, '{')) {
            return $pattern;
        }
        return preg_replace_callback('#\{(\w+):(\w+)\}#', function($match) {
            $patterns = [
                'i' => '[0-9]+',
                's' => '[a-zA-Z\.\-_%]+',
                'x' => '[a-zA-Z0-9\.\-_%]+',
            ];
            list(, $name, $prce) = $match;
            return '(?<'.$name.'>'.strtr($prce, $patterns).')';
        }, $pattern);
    }
    /**
     * Добавляет массив роутов в обработчик
     * @param array $routes Массив роутов
     */
    public function withRoutes(array $routes = [])
    {
        foreach ($routes as $route) {
            $this->withRoute(
                $route['name'],
                $route['pattern'],
                $route['handler'],
                $route['method']
            );
        }
    }
    /**
     * Обрабатывает uri по роуту
     * @param string $uri Обрабатываемый uri
     * @param string $method Метод запроса
     * @throws ErrorException Исключение выбрасываемое при отсутствии роутов
     * @return array Массив с даныыми контролера
     */
    public function match($uri = null, $method = RequestInterface::METH_GET)
    {
        if (array_key_exists($uri, $this->patterns[$method])) {
            return $this->compareParam($this->patterns[$method][$uri]);
        }
        $matches = [];
        foreach ($this->routes[$method] as $route) {
            if (preg_match('#^'.$route['pattern'].'$#s', $uri, $matches)) {
                return $this->compareParam(
                    $route['handler'],
                    $this->getParams($matches)
                );
            }
        }
        return $this->compareParam();
        
    }
    /**
     * Фильтрует и возвращает параметры запроса
     * @param array $params Паараметры запроса
     * @return array Параметры запроса
     */
    protected function getParams($params)
    {
        return array_filter($params, function($param) {
            return ! is_int($param);
        });
    }
    /**
     * Компонует обработчик роута и параметры в единый массив
     * @param string $handler
     * @param array $params
     * @return type
     */
    protected function compareParam($handler = null, array $params = []) {
        return [
            'handler' => $handler,
            'params' => $params
        ];
    }
}
