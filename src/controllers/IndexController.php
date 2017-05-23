<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 23/05/2017
     * Time: 14:08
     */

    namespace net\devtales\controllers;
    use net\devtales\framework\TemplateResolver;

    require_once $_SERVER['DOCUMENT_ROOT'] .'\vendor\autoload.php';


    class IndexController
    {
        private $templateResolver;

        public function __construct(TemplateResolver $templateResolver)
        {
            $this->templateResolver = $templateResolver;
        }

        public function base()
        {
             $params = array(
                'name' => 'Krzysztof',
                'friends' => array(
                    array(
                        'firstname' => 'John',
                        'lastname' => 'Smith'
                    ),
                    array(
                        'firstname' => 'Britney',
                        'lastname' => 'Spears'
                    ),
                    array(
                        'firstname' => 'Brad',
                        'lastname' => 'Pitt'
                    )
                )
            );

            $this->templateResolver->resolve('hello.phtml', $params);
        }
    }