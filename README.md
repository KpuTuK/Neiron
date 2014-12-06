Neiron
======

PHP 5x Micro Framework

Установка
---------
1. Скачиваем последнюю версию по ссылке https://github.com/KpuTuK/Neiron/archive/master.zip
2. Распаковываем архив корневую директорию сайта

Настройка
----------------

```php
// Подключаем автозагрузчик классов
require_once __DIR__ .'/Neiron/Kernel/ClassLoader.php';
// Создаем обьект автозагрузчика указывая корневую директорию скрипта
$load = new \Neiron\Kernel\ClassLoader(__DIR__.'/');
// Регистрируем автозагрузчик
$load->register();
// Создаем обьект ядра фреймворка
$app = new \Neiron\Kernel\Neiron();

// Ваш код

$app->run();
```
Все параметры вы можете задать как при создании обьекта
```php
$app = new \Neiron\Kernel\Neiron(array(
    // Ваши параметры
));
```
так и непосредственно через **$app**
```php
$app['some.parametr'] = 'содержимое параметра';
```
Все параметры записываются в Dependency injection контейнер и становятся доступными в любом месте 
Роутинг
-------
Роуты можно сохранять различными методами:
```php
$app = new \Neiron\Kernel\Neiron(array(
    'routes' => __DIR__.'/routes.php'
));
$app->get($name, $pattern, $handler);
$app['routing']->addRoute($name, $pattern, $handler, $method);
$app['routing']->addRoutes(__DIR__.'/routes.php');
// Содержимое /routes.php
return array(
    array(
        'name' => 'Имя роута'
        'pattern' => 'Паттерн обработки'
        'handler' => 'Анонимная функция или строка вида "пространство имен контроллера@экшен"'
        'method' => 'Метод запроса'
    )
);
```
HMVC
-----
Neiron основывается на паттерне [HMVC](https://ru.wikipedia.org/wiki/HMVC) (пока внутри приложения)
Для запроса внутри одного конроллера к другому достаточно прописать:
```php
// для классов контроллеров
class TestController implements Neiron\Arhitecture\Kernel\ControllerInterface
{
    public function index()
    {
        $query = $this->request->create($uri, $method);
    }
}
// Для анонимных функций 
function ($params)
{
    // $params['dic'] - Обьект Dependency injection контейнера
    $query = $params['dic']['request']->create($uri, $method);
}
```
Данный код запустит запустит контроллер (указанный в массиве роутов и подходящий под данный uri),
сохранит контент запущенного `uri` в `Neiron\Kernel\Response` 
и передаст `$query` обьект класса `Neiron\Kernel\Response`.

#Глобальные перемееные
Для доступа к глобальным переменным используйте свойства:
* *globals* для $GLOBALS
* *server* для $_SERVER
* *query* для $_GET
* *post* для $_POST
* *files* для $_FILES
* *cookie* для $_COOKIE

Для добавления массива переменных в глобальную переменную используйте метод `merge()`

```php
// Запись
$app['request']->query['get_name'] = 'get value';
// Вывод
echo $app['request']->query['get_name']; // Выводит get value 
// Проверка наличия
var_dump(isset($app['request']->query['get_name'])); // true
// Удаление
unset($app['request']->query['get_name']);
// Проверка наличия
var_dump(isset($app['request']->query['get_name'])); // false
// Запись массива
$app['request']->query->merge(array(
    'value1', 'value2' => 'test'
));
// Проерка наличия первого значения массива
var_dump(isset($app['request']->query['value1'])); // true
// Проверка наличия второго значения массива
var_dump(isset($app['request']->query['value2'])); // true
// Вывод содержимого второго значения массива
echo $app['request']->query['value2']; // Выводит test
```
