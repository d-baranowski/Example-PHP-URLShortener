<?php
    require_once $_SERVER['DOCUMENT_ROOT']. '.\vendor\autoload.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'\src\framework\SimpleDependencyResolver.php';
    use net\devtales\framework\SimpleDependencyResolver;


    $container = new SimpleDependencyResolver();

    // Holds data like $baseUrl etc.
    $configs = include('config.php');

    $requestUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $requestString = $_SERVER['REQUEST_URI'];

    $urlParams = explode('/', $requestString);

    $controllerName = ucfirst(array_shift($urlParams)).'IndexController';
    $actionName = strtolower(array_shift($urlParams)).'base';


    $controller = $container->get($controllerName);
    $controller->$actionName();