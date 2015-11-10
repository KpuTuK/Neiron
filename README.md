Neiron 
======

[![Join the chat at https://gitter.im/KpuTuK/Neiron](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/KpuTuK/Neiron?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KpuTuK/Neiron/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KpuTuK/Neiron/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/KpuTuK/Neiron/badges/build.png?b=master)](https://scrutinizer-ci.com/g/KpuTuK/Neiron/build-status/master)
[![HHVM Status](http://hhvm.h4cc.de/badge/kputuk/neiron.svg)](http://hhvm.h4cc.de/package/kputuk/neiron)
[![Codacy Badge](https://api.codacy.com/project/badge/grade/eeece6bd26654116b0bd824c72b1aaee)](https://www.codacy.com/app/srv16rus/Neiron)
[![Code Climate](https://codeclimate.com/github/KpuTuK/Neiron/badges/gpa.svg)](https://codeclimate.com/github/KpuTuK/Neiron)

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
