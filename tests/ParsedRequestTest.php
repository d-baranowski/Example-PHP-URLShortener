<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 24/05/2017
     * Time: 00:29
     */

    namespace net\devtales\tests;
    require_once $_SERVER['DOCUMENT_ROOT'].'.\vendor\autoload.php';
    require_once __DIR__.'\..\src\framework\ParsedRequest.php';

    use InvalidArgumentException;
    use net\devtales\framework\ParsedRequest;
    use PHPUnit\Framework\TestCase;



    class ParsedRequestTest extends TestCase
    {
        public function testRequestToIndex()
        {
            $req = new ParsedRequest("localhost:8000", "/");
            $this->assertEquals('IndexController', $req->controller);
            $this->assertEquals('base', $req->action);
            $this->assertEquals(array(), $req->query);
        }

        public function testNullSafety()
        {
            try 
            {
                new ParsedRequest(NULL, NULL);
            } catch (InvalidArgumentException $e)
            {
                $this->assertTrue($e->getMessage() == 'Host or URI cannot be null.');
            }
        }

        public function testExampleControllerRequest()
        {
            $req = new ParsedRequest("localhost:8000", "/example/helloWorld?name=Daniel&enjoy=programming");
            $this->assertEquals('ExampleController', $req->controller);
            $this->assertEquals('helloworld', $req->action);
            $this->assertEquals(array('name' => 'Daniel', 'enjoy' => 'programming'), $req->query);
        }
    }