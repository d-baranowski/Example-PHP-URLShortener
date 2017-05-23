<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 23/05/2017
     * Time: 15:28
     */

    namespace net\devtales\framework;


    use Twig_Environment;

    class TemplateResolver
    {
        private $myTwig;

        public function __construct(Twig_Environment $twig)
        {
            $this->myTwig = $twig;
        }

        public function resolve($templateName, $params)
        {
            $template = $this->myTwig->load($templateName);
            $template->display($params);
        }
    }