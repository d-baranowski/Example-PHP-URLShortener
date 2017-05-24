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

    $PROJECT_ROOT = ($_SERVER['DOCUMENT_ROOT'] ?: '.');
    require_once $PROJECT_ROOT.'/vendor/autoload.php';
    require_once $PROJECT_ROOT.'/src/repositories/UrlMapRepository.php';
    require_once $PROJECT_ROOT.'/src/framework/SimpleResponseResolver.php';
    require_once $PROJECT_ROOT.'/src/framework/SimpleResponse.php';
    require_once $PROJECT_ROOT.'/src/framework/TemplateResolver.php';
    require_once $PROJECT_ROOT.'/src/controllers/IndexController.php';
    require_once $PROJECT_ROOT.'/src/controllers/ShortenController.php';
    require_once $PROJECT_ROOT.'/src/entities/UrlMap.php';
    require_once $PROJECT_ROOT.'/src/logic/ShortUrlGenerator.php';
    require_once $PROJECT_ROOT.'/src/logic/ShortUrlRedirect.php';

    use net\devtales\controllers\IndexController;
    use net\devtales\controllers\ShortenController;
    use net\devtales\logic\ShortUrlGenerator;
    use net\devtales\logic\ShortUrlRedirect;
    use net\devtales\repositories\UrlMapRepository;
    use Twig_Environment;
    use Twig_Loader_Filesystem;
    use Doctrine\ORM\Tools\Setup;
    use Doctrine\ORM\EntityManager;
    use Doctrine\DBAL\DriverManager;

class SimpleDependencyResolver
{
    private $_dependencyBuilders;
    public function __construct()
    {
        global $PROJECT_ROOT;
        $this->_dependencyBuilders = array(
            'EntityManager' => function() use ($PROJECT_ROOT)
            {
                $isDevMode = true;
                $config = Setup::createAnnotationMetadataConfiguration(
                    array($PROJECT_ROOT."/src/entities"),
                    $isDevMode
                );

                $connParams = array(
                    'dbname' => 'urlshortener',
                    'user' => (getenv('URL_SHORTENER_DB_USER') ?: $_SERVER['URL_SHORTENER_DB_USER']),
                    'password' => (getenv('URL_SHORTENER_DB_PASSWORD') ?: $_SERVER['URL_SHORTENER_DB_PASSWORD']),
                    'host' => 'localhost',
                    'driver' => 'pdo_mysql'
                );

                $conn = DriverManager::getConnection($connParams, $config);
                return EntityManager::create($conn, $config);
            },
            'UrlMapRepository' => function()
            {
                return new UrlMapRepository($this->get('EntityManager'));
            },
            'ShortUrlGenerator' => function()
            {
                return new ShortUrlGenerator($this->get('UrlMapRepository'), $_SERVER['HTTP_HOST']);
            },
            'Twig' => function () {
                $loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'].'/src/templates');
                return new Twig_Environment(
                    $loader, array(
                    //'cache' => '/tmp/cache', Enable in production
                    )
                );
            },
            'TemplateResolver' => function() {
                return new TemplateResolver($this->get("Twig"));
            },
            'ResponseResolver' => function() {
                return new SimpleResponseResolver();
            },
            'IndexController' => function() {
                return new IndexController($this->get("TemplateResolver"));
            },
            'ShortenController' => function() {
                return new ShortenController(
                    $this->get("ResponseResolver"),
                    $this->get('UrlMapRepository'),
                    $this->get('ShortUrlGenerator'));
            },
            'ShortUrlRedirect' => function() {
                return new ShortUrlRedirect(
                    $this->get('UrlMapRepository'),
                    $_SERVER['HTTP_HOST'],
                    'http://');
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
