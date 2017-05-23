<?php
    /**
     * PHP Version 7
     *
     * @category View_Controller
     * @package  Controllers
     * @author   Daniel Baranowski <d.baranowski@devtales.net>
     * @link     https://github.com/d-baranowski/Example-PHP-URLShortener repo
     */

    namespace net\devtales\controllers;
    use net\devtales\framework\TemplateResolver;

    require_once $_SERVER['DOCUMENT_ROOT'] .'\vendor\autoload.php';

class IndexController
{
    private $_templateResolver;

    public function __construct(TemplateResolver $templateResolver)
    {
        $this->_templateResolver = $templateResolver;
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

        $this->_templateResolver->display('index.twig', $params);
    }
}
