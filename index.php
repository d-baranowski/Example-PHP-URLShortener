<?php
    require_once $_SERVER['DOCUMENT_ROOT']. '.\vendor\autoload.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'\src\framework\SimpleDependencyResolver.php';
    use net\devtales\framework\SimpleDependencyResolver;


    $container = new SimpleDependencyResolver();

    // Holds data like $baseUrl etc.
    $configs = include 'config.php';

    $requestUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $requestString = $_SERVER['REQUEST_URI'];

    $urlParams = explode('/', $requestString);

    $endpoint = ucfirst(array_shift($urlParams)).'index';
    $actionName = strtolower(array_shift($urlParams)).'base';
    $controllerName = ucfirst ( strtolower($endpoint)) . 'Controller';

    if ($container->hasDependency($controllerName))
    {
        $controller = $container->get($controllerName);
        if (method_exists ($controller, $actionName))
        {
            $controller->$actionName();
            return;
        }
    }
    $container->get('TemplateResolver')->display('notfound.twig');
