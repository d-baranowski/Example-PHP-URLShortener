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
    use net\devtales\repositories\iUrlMapRepository;


    class IndexController
{
    private $templateResolver;
    private $repository;

    public function __construct(TemplateResolver $templateResolver, iUrlMapRepository $repository)
    {
        $this->templateResolver = $templateResolver;
        $this->repository = $repository;
    }

    public function base()
    {
        $urlMaps = $this->repository->getAll();
        $params = array(
         'urlMaps' => $urlMaps
        );

        $this->templateResolver->display('index.twig', $params);
    }
}
