<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 24/05/2017
     * Time: 00:29
     */

    namespace net\devtales\tests;
    require_once __DIR__.'\..\src\framework\ParsedRequest.php';

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
    }