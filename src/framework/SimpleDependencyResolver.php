<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 23/05/2017
     * Time: 16:50
     */

    namespace net\devtales\framework;

    require_once $_SERVER['DOCUMENT_ROOT'].'\src\framework\TemplateResolver.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'\src\controllers\IndexController.php';
    use net\devtales\controllers\IndexController;
    use Twig_Environment;
    use Twig_Loader_Filesystem;

    class SimpleDependencyResolver
    {
        private $dependencyBuilders;
        public function __construct()
        {
            $this->dependencyBuilders = array(
                'Twig' => function () {
                    $loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'].'\src\templates');
                    return new Twig_Environment($loader, array(
                        'cache' => '../tmp/cache',
                    ));
                },
                'TemplateResolver' => function () {
                    return new TemplateResolver($this->get("Twig"));
                },
                'IndexController' => function () {
                    return new IndexController($this->get("TemplateResolver"));
                }
            );
        }

        function get(string $dependency)
        {
            $function = $this->dependencyBuilders[$dependency];
            return  $function();
        }
    }