<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 24/05/2017
     * Time: 01:24
     */

    namespace net\devtales\framework;

    interface iSimpleResponseResolver
    {
        public function resolve(SimpleResponse $response);
    }

    class SimpleResponseResolver implements iSimpleResponseResolver
    {
        public function resolve(SimpleResponse $response)
        {
            header('Content-Type: '.$response->type);
            http_response_code($response->code);
            echo $response->body;
        }
    }