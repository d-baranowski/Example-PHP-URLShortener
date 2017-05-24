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

    use net\devtales\controllers\ShortenController;
    use net\devtales\framework\iSimpleResponseResolver;
    use net\devtales\framework\SimpleResponse;
    use PHPUnit\Framework\TestCase;



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
            });
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
            });
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
            });
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
            });
            $controller->base(array('url' => 'http://google.com'));
        }
    }