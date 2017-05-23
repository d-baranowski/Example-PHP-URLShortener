<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 23/05/2017
     * Time: 22:41
     */

    namespace net\devtales\controllers;


    class ShortenController
    {
        public function base($requestParams)
        {
            header('Content-Type: text/plain');
            if (array_key_exists('url',$requestParams)) {
                $url = $requestParams['url'];
                if (strlen($url) > 0 && strlen($url) < 999)
                {
                    if (filter_var($url, FILTER_VALIDATE_URL))
                    {
                        http_response_code(200);
                        echo "Looks good";
                        return;
                    }
                }
            }
            http_response_code(400);
            echo "Make sure to provide a valid url as a url parameter of your request.";
            return;
        }
    }