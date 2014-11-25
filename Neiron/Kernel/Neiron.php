<?php
/**
 * PHP 5x framework с открытым иходным кодом
 */
namespace Neiron\Kernel;
use Neiron\Arhitecture\Kernel\ApplicationInterface;
use Neiron\Arhitecture\Kernel\RequestInterface;
require_once dirname(__DIR__) . '/Arhitecture/Kernel/ApplicationInterface.php';
/**
 * Базовый класс framework'a
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class Neiron implements ApplicationInterface {
    /**
     * Версия frameworka
     */
    const VERSION = '1.0.0';
    /**
     * Весрсия согласно дате релиза с пометками beta|stable
     */
    const DAYVERSION = '25.11.14 beta';
    /**
     * Dependicy Inection контейнер
     * @var array
     */
    private $container = array();
    /**
     * Конструктор класса
     * @param array $options Массив настроек (опционально)
     */
    public function __construct(array $options = array()) {
        $this->setup($options);
        spl_autoload_register(array($this, 'classLoader'), false);
        $this['routing'] = new Routing();
        $this['routing']->addRoutes($this['routes']);
        $this['request'] = new Request($this);
        $this['response'] = new Response($this['request']);
    }
    /**
     * Настраивает значения по умолчанию для настроек
     * @param array $options Массив настроек
     */
    private function setup(array $options = array()) {
        if ( ! isset($options['dir.root'])) {
            $options['dir.root'] = dirname(dirname(__DIR__)) .'/';
        }
        if ( ! isset($options['pathes'])) {
            $options['pathes'] = array();
        }
        if ( ! isset($options['routes'])) {
            $options['routes'] = array();
        }
        $this->container = array_merge($this->container, $options);
    }
    /**
     * Добавляет обработчик роута по паттерну вызываемого методом GET
     * @param sring $name Имя роута
     * @param string $pattern Паттерн обработки роута
     * @param mixed $handler Обработчик роута
     */
    public function get($name, $pattern, $handler) {
        $this['routing']->addRoute($name, $pattern, $handler, RequestInterface::METH_GET);
    }
    /**
     * Добавляет обработчик роута по паттерну вызываемого методом POST
     * @param sring $name Имя роута
     * @param string $pattern Паттерн обработки роута
     * @param mixed $handler Обработчик роута
     */
    public function post($name, $pattern, $handler) {
        $this['routing']->addRoute($name, $pattern, $handler, RequestInterface::METH_POST);
    }
    /**
     * Добавляет обработчик роута по паттерну вызываемого методом PUT
     * @param sring $name Имя роута
     * @param string $pattern Паттерн обработки роута
     * @param mixed $handler Обработчик роута
     */
    public function put($name, $pattern, $handler) {
        $this['routing']->addRoute($name, $pattern, $handler, RequestInterface::METH_PUT);
    }
    /**
     * Добавляет обработчик роута по паттерну вызываемого методом PUT
     * @param sring $name Имя роута
     * @param string $pattern Паттерн обработки роута
     * @param mixed $handler Обработчик роута
     */
    public function delete($name, $pattern, $handler) {
        $this['routing']->addRoute($name, $pattern, $handler, RequestInterface::METH_DELETE);
    }
    /**
     * Функция автоматической загрузки классов
     * @param string $class Пространство имени класса
     * @return bool null
     * @throws \ErrorException Исключение выбрасываемое в случае отсутствия класса
     */
    public function classLoader($class) {
        $path .= $this['dir.root'];
        $path .= str_replace(
            array_keys($this['pathes']),
            array_values($this['pathes']), 
            $class
        );
        $path .= '.php';
        if (file_exists($path)) {
            require_once $path;
            return;
        }
        throw new \ErrorException(sprintf('Класс "%s" не найден!', $path));
    }
    /**
     * Проверяет наличие параметра в контейнере
     * @param string $offset Проверяемый параметр
     * @return bool true параметр найден или false если параметр отсутсвует
     */
    public function offsetExists($offset) {
        return array_key_exists($offset, $this->container);
    }
    /**
     * Сохраняет содержимое в контейнер по ключу
     * @param string $offset Ключ
     * @param mixed $value Сохраняемое содержимое
     * @throws \InvalidArgumentException Исключение выбрасываемое в случае если ключ уже существует в контейнере
     */
    public function offsetSet($offset, $value) {
        if ($this->offsetExists($offset)) {
            throw new \InvalidArgumentException(
                sprintf('Параметр "%s" уже существует!', $offset)
            );
        }
        $this->container[$offset] = $value;
    }
    /**
     * Возвращает содержимое контейнера по ключу
     * @param string $offset Ключ содержимого
     * @return mixed Содержимое
     * @throws \InvalidArgumentException Исключение выбрасываемое в случае отсутствия ключа в контейнере
     */
    public function offsetGet($offset) {
        if ( ! $this->offsetExists($offset)) {
            throw new \InvalidArgumentException(
                sprintf('Параметр "%s" не существует!', $offset)
            );
        }
        return $this->container[$offset];
    }
    /**
     * Удаляет содержимое по ключу в контейнере
     * @param string $offset Ключ содержимого
     * @throws \InvalidArgumentException Исключение выбрасываемое в случае отсутствия ключа в контейнере
     */
    public function offsetUnset($offset) {
        if ( ! $this->offsetExists($offset)) {
            throw new \InvalidArgumentException(
                sprintf('Параметр "%s" не существует!', $offset)
            );
        }
        unset($this->container[$offset]);
    }
    /**
     * Запускает приложение
     */
    public function run() {
        $this['request']->create()->execute()->body();
    }
}
