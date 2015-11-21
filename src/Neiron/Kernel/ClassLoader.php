<?php
/**
* PHP 5.4 framework с открытым иходным кодом
*/
namespace Neiron\Kernel;

/**
 * Автоматический загрузчик классов
 * @author KpuTuK
 * @version 1.0.0
 * @package Neiron framework
 * @category Kernel
 * @link
 */
class ClassLoader
{
    /**
     * Корневая директория классов
     * @var mixed
     */
    protected $rootDir;
    /**
     * Массив классов и пространств имен к ним
     * @var array
     */
    protected $pathes = array();
    /**
     * Конструктор класса
     * @param mixed $rootDir Корневая директория классов
     */
    public function __construct($rootDir = null)
    {
        $this->rootDir = $rootDir . DIRECTORY_SEPARATOR;
    }
    /**
     * Доавляет класс и пространство имен в массив
     * @param string $class
     * @param string $namespace
     * @return \Neiron\Kernel\ClassLoader
     */
    public function withPath($class, $namespace)
    {
        $this->pathes[(string)$class] = (string)$namespace;
        return $this;
    }
    /**
     * Добавляет массив классов и пространств имен к ним
     * @param array $pathes Массив классов и пространств имен к ним
     * @return \Neiron\Kernel\ClassLoader
     */
    public function withPathes(array $pathes)
    {
        $this->pathes = array_merge($this->pathes, $pathes);
        return $this;
    }
    /**
     * Преоразует путь классу согласно пространству имен
     * @param string $class Преоразуемый класс
     * @return string Преобразованный класс
     */
    protected function preparePatch($class)
    {
        if (count($this->pathes) !== 0) {
            $class = str_replace(
                    array_keys($this->pathes), array_values($this->pathes), $class
            );
        }
        return $class;
    }
    /**
     * Возвращает полный путь к классу
     * @param string $class Искомый класс
     * @return string Полный путь к классу
     * @throws \ErrorException Исключение выбрасываемое в случае отсутствия класса
     */
    protected function getFilePatch($class)
    {
        $path = $this->rootDir.$this->preparePatch($class).'.php';
        $file = str_replace(['\\', '_'], DIRECTORY_SEPARATOR, $path);
        if (file_exists($file)) {
            return $file;
        }
        throw new \ErrorException(sprintf('Класс {"%s"} не найден!', $file));
    }
    /**
     * Подключает класс
     * @param string $class Подключаемый класс
     */
    protected function loadClass($class)
    {
        require_once $this->getFilePatch($class);
    }
    /**
     * Регистрирует автозагрузчк классов
     * @param booleran $prepend 
     */
    public function register($prepend = false)
    {
        spl_autoload_register(array($this, 'loadClass'), false, $prepend);
    }
    /**
     * Удаляет автозагрузчик классов
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }
}
