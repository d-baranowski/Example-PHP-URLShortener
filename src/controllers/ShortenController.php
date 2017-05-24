<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 23/05/2017
     * Time: 22:41
     */

    namespace net\devtales\controllers;
    require_once $_SERVER['DOCUMENT_ROOT'] .'\vendor\autoload.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'\src\framework\SimpleResponseResolver.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'\src\framework\SimpleResponse.php';


    use net\devtales\framework\iSimpleResponseResolver;
    use net\devtales\framework\SimpleResponse;


    class ShortenController
    {
        private $resolver;
        public function __construct(iSimpleResponseResolver $resolver)
        {
            $this->resolver = $resolver;
        }

        public function base($requestParams)
        {
            if (array_key_exists('url',$requestParams)) {
                $url = $requestParams['url'];
                if (strlen($url) > 0 && strlen($url) < 999)
                {
                    if (filter_var($url, FILTER_VALIDATE_URL))
                    {
                        $this->resolver->resolve(new SimpleResponse("Looks good"));
                        return;
                    }
                }
            }
            $this->resolver->resolve(new SimpleResponse(
                "Make sure to provide a valid url as a url parameter of your request.",
                400
            ));
            return;
        }
    }