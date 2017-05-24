<?php
    require_once './vendor/autoload.php';
    require_once './src/framework/SimpleDependencyResolver.php';
    use net\devtales\framework\SimpleDependencyResolver;
    $container = new SimpleDependencyResolver();

    return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($container->get('EntityManager'));