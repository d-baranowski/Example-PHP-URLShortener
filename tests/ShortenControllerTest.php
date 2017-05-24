<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 24/05/2017
     * Time: 01:32
     */

    namespace net\devtales\tests;

    require_once __DIR__.'\..\vendor\autoload.php';
    require_once __DIR__.'\..\src\controllers\ShortenController.php';
    require_once __DIR__.'\..\src\framework\SimpleResponse.php';
    require_once __DIR__.'\..\src\framework\SimpleResponseResolver.php';
    require_once __DIR__.'\..\src\controllers\ShortenController.php';
    require_once __DIR__.'\..\src\repositories\UrlMapRepository.php';
    require_once __DIR__.'\..\src\logic\ShortUrlGenerator.php';
    require_once __DIR__.'\..\src\entities\UrlMap.php';

    use net\devtales\controllers\ShortenController;
    use net\devtales\framework\iSimpleResponseResolver;
    use net\devtales\framework\SimpleResponse;
    use net\devtales\logic\iShortUrlGenerator;
    use net\devtales\repositories\iUrlMapRepository;
    use PHPUnit\Framework\TestCase;
    use UrlMap;

    class EmptyUrlMapMock implements iUrlMapRepository{
        public function save(UrlMap $map)
        {
            // Empty mock.
        }

        public function getAll()
        {
            // Empty mock.
        }

        public function findByLong($longUrl)
        {
            // Empty mock.
        }

        public function findByShort($shortUrl)
        {
            // Empty mock.
        }
    };

    class ShortenControllerTest extends TestCase
    {
        public function testBadRequestWhenUrlNotPresent()
        {
            $controller = new ShortenController(new class extends ShortenControllerTest implements iSimpleResponseResolver
            {
                public function resolve(SimpleResponse $response)
                {
                    $this->assertEquals(400, $response->code);
                }
            }, $this->getEmptyUrlMapMock(), $this->getEmptyShortUrlGeneratorMock());
            $controller->base(array());
        }

        public function testBadRequestWhenUrlEmpty()
        {
            $controller = new ShortenController(new class extends ShortenControllerTest implements iSimpleResponseResolver
            {
                public function resolve(SimpleResponse $response)
                {
                    $this->assertEquals(400, $response->code);
                }
            },$this->getEmptyUrlMapMock(), $this->getEmptyShortUrlGeneratorMock());
            $controller->base(array('url' => ''));
        }

        public function testBadRequestWhenUrlTooLong()
        {
            $controller = new ShortenController(new class extends ShortenControllerTest implements iSimpleResponseResolver
            {
                public function resolve(SimpleResponse $response)
                {
                    $this->assertEquals(400, $response->code);
                }
            },$this->getEmptyUrlMapMock(), $this->getEmptyShortUrlGeneratorMock());
            $controller->base(array('url' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'));
        }

        public function testOkWhenUrlValid()
        {
            $controller = new ShortenController(new class extends ShortenControllerTest implements iSimpleResponseResolver
            {
                public function resolve(SimpleResponse $response)
                {
                    $this->assertEquals(200, $response->code);
                }
            },$this->getEmptyUrlMapMock(), new class implements iShortUrlGenerator{
                public function getShort($long, $i = 0)
                {
                    return "http://mock/welcome";
                }
            });
            $controller->base(array('url' => 'http://google.com'));
        }

        public function testBadRequestIfUrlExists()
        {
            $controller = new ShortenController(new class extends ShortenControllerTest implements iSimpleResponseResolver
            {
                public function resolve(SimpleResponse $response)
                {
                    $this->assertEquals(400, $response->code);
                    $this->assertEquals('This url is already shortened by us. http://mocked.com/12345', $response->body);
                }
            },  new class extends EmptyUrlMapMock
            {
                public function findByLong($longUrl)
                {
                    $map = new UrlMap();
                    $map->setShortUrl("http://mocked.com/12345");
                    return $map;
                }
            }, $this->getEmptyShortUrlGeneratorMock());
            $controller->base(array('url' => 'http://google.com'));
        }

        private function getEmptyUrlMapMock()
        {
            return new class implements iUrlMapRepository{
                public function save(UrlMap $map)
                {
                    // Empty mock.
                }

                public function getAll()
                {
                    // Empty mock.
                }

                public function findByLong($longUrl)
                {
                    // Empty mock.
                }

                public function findByShort($shortUrl)
                {
                    // Empty mock.
                }
            };
        }
        private function getEmptyShortUrlGeneratorMock()
        {
            return new class implements iShortUrlGenerator{
                public function getShort($long, $i = 0)
                {
                    // Empty mock.
                }
            };
        }
    }