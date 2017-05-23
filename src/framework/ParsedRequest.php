<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 23/05/2017
     * Time: 23:35
     */

    namespace net\devtales\framework;
    require_once

    class ParsedRequest
    {
        public $controller;
        public $action;
        public $query;

        public function __construct($host, $uri)
        {
            $requestUrl = 'http://'.$host.$uri;
            $parsedUrl = parse_url($requestUrl);
            $urlParams = explode('/', $parsedUrl['path']);
            array_shift($urlParams); // Remove first empty element

            $queryParams = array();
            if (array_key_exists('query',$parsedUrl))
            {
                parse_str($parsedUrl['query'], $queryParams);
            }

            $endpoint = array_shift($urlParams) ?: 'index';

            $this->action =  strtolower(array_shift($urlParams)) ?: 'base';
            $this->controller = ucfirst ( strtolower($endpoint)) . 'Controller';
            $this->query = $queryParams;
        }
    }