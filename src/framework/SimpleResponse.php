<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 24/05/2017
     * Time: 01:20
     */

    namespace net\devtales\framework;


    class SimpleResponse
    {
        public $body;
        public $type;
        public $code;

        public function __construct($body, $code = 200, $type = 'plain/text')
        {
            $this->body = $body;
            $this->code = $code;
            $this->type = $type;
        }
    }