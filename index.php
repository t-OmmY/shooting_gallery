<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// подключение конфига
require_once 'config.php';


// автозагрузка классов - перебираем каждый каталог, где могут лежать классы, и подключаем, если находим
function __autoload($className)
{
    $file = "{$className}.php";
    if (file_exists(LIB_DIR . $file)) {
        require LIB_DIR . $file;
    } elseif (file_exists(CONTROLLER_DIR . $file)) {
        require CONTROLLER_DIR . $file;
    } elseif (file_exists(MODEL_DIR . $file)) {
        require MODEL_DIR . $file;
    } else {
        die("{$file} not found");
    }
}


Session::start();

try{
    // принимаем запрос, создавая новые экземпляр класса Request
    $request = new Request();

    if (isset ($_POST['ajax'])){
        $_controller = ucfirst(strtolower($request->post('controller'))) . 'Controller';
        $_action = strtolower($request->post('action')) . 'Action';
    } else {

// обработка роута, который задан по правилу: контроллер/действие"
        $route = $request->get('route');

// если в ГЕТе не пришло роута, то по умолчанию index/index
        if (!$route) {
            $route = 'index/index';
        }

// определяем названия контроллера и действия
        $route = explode('/', $route);
        $_controller = $route[0];
        $_action = $route[1];

// приводим названия к виду типа BookController, indexAction из Book, index (например)
        $_controller = ucfirst(strtolower($_controller)) . 'Controller';
        $_action = strtolower($_action) . 'Action';

    }

// создаем экземпляр контроллера
    $_controller = new $_controller;

// вызываем действие для обработки запроса - оно сгенерирует динамический контент
    $content = $_controller->$_action($request);
} catch (Exception $e) {
    $content = $e->getCode() . " : " . $e->getMessage();
}

if (!isset($_POST['ajax'])){
    require VIEW_DIR . 'layout.phtml';
}

