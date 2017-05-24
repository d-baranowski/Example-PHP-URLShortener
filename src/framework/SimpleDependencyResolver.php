<?php
    /**
     * PHP Version 7
     *
     * @category Dependency_Resolver
     * @package  Framework
     * @author   Daniel Baranowski <d.baranowski@devtales.net>
     * @link     https://github.com/d-baranowski/Example-PHP-URLShortener repo
     */

    namespace net\devtales\framework;

    require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/framework/SimpleResponseResolver.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/framework/SimpleResponse.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/framework/TemplateResolver.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/controllers/IndexController.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/controllers/ShortenController.php';

    use net\devtales\controllers\IndexController;
    use net\devtales\controllers\ShortenController;
    use Twig_Environment;
    use Twig_Loader_Filesystem;

class SimpleDependencyResolver
{
    private $_dependencyBuilders;
    public function __construct()
    {
        $this->_dependencyBuilders = array(
            'Twig' => function () {
                $loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'].'/src/templates');
                return new Twig_Environment(
                    $loader, array(
                    //'cache' => '/tmp/cache',
                    )
                );
            },
            'TemplateResolver' => function () {
                return new TemplateResolver($this->get("Twig"));
            },
            'ResponseResolver' => function() {
                return new SimpleResponseResolver();
            },
            'IndexController' => function () {
                return new IndexController($this->get("TemplateResolver"));
            },
            'ShortenController' => function() {
                return new ShortenController($this->get("ResponseResolver"));
            }
        );
    }

    function hasDependency(string $dependency)
    {
        return array_key_exists($dependency, $this->_dependencyBuilders);
    }

    function get(string $dependency)
    {
        $function = $this->_dependencyBuilders[$dependency];
        return  $function();
    }
}
