<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/framework/SimpleDependencyResolver.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/framework/ParsedRequest.php';
    use net\devtales\framework\ParsedRequest;
    use net\devtales\framework\SimpleDependencyResolver;

    $container = new SimpleDependencyResolver();

    $req = new ParsedRequest($_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']);

    $container->get('ShortUrlRedirect')->redirectIfShortUrlExits($_SERVER['REQUEST_URI']);

    if ($container->hasDependency($req->controller))
    {
        $controller = $container->get($req->controller);
        if (method_exists ($controller, $req->action))
        {
            $action = $req->action;
            $controller->$action($req->query);
            return;
        }
    }
    $container->get('TemplateResolver')->display('notfound.twig');
