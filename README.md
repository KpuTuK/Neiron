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