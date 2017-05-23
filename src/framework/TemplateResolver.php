<?php
    /**
     * PHP Version 7
     *
     * @category Template_Resolver
     * @package  Framework
     * @author   Daniel Baranowski <d.baranowski@devtales.net>
     * @license  https://opensource.org/licenses/MIT MIT
     * @link     https://github.com/d-baranowski/Example-PHP-URLShortener repo
     */

    namespace net\devtales\framework;


    use Twig_Environment;

class TemplateResolver
{
    private $_twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->_twig = $twig;
    }

    public function display($templateName, $params = array())
    {
        $template = $this->_twig->load($templateName);
        $template->display($params);
    }
}
