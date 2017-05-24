<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 23/05/2017
     * Time: 22:41
     */

    namespace net\devtales\controllers;

    use net\devtales\framework\iSimpleResponseResolver;
    use net\devtales\framework\SimpleResponse;
    use net\devtales\repositories\iUrlMapRepository;


    class ShortenController
    {
        private $resolver;
        public function __construct(iSimpleResponseResolver $resolver, iUrlMapRepository $repository)
        {
            $this->resolver = $resolver;
        }

        public function base($requestParams)
        {
            if (array_key_exists('url',$requestParams)) {
                $url = $requestParams['url'];
                if (strlen($url) > 0 && strlen($url) < 100)
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