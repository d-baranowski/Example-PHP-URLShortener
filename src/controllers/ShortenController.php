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
    use net\devtales\logic\iShortUrlGenerator;
    use net\devtales\repositories\iUrlMapRepository;
    use PHPStan\ShouldNotHappenException;


    class ShortenController
    {
        private $resolver;
        private $repository;
        private $generator;
        public function __construct(iSimpleResponseResolver $resolver,
                                    iUrlMapRepository $repository,
                                    iShortUrlGenerator $generator)
        {
            $this->resolver = $resolver;
            $this->repository = $repository;
            $this->generator = $generator;
        }

        private function persist($url, $short)
        {
            $map = new \UrlMap();
            $map->setLongUrl($url);
            $map->setShortUrl($short);
            $this->repository->save($map);
            return $map;
        }

        public function base($requestParams)
        {
            if (!array_key_exists('url',$requestParams))
            {
                $this->resolver->resolve(new SimpleResponse(
                    "Make sure to provide a valid url as a parameter of your request.",
                    400
                ));
                return;
            }
            $url = $requestParams['url'];
            if (strlen($url) < 10 || strlen($url) > 999)
            {
                $this->resolver->resolve(new SimpleResponse(
                    "Url has to be between 10 and 999 characters long.",
                    400
                ));
                return;
            }
            if (!filter_var($url, FILTER_VALIDATE_URL))
            {
                $this->resolver->resolve(new SimpleResponse(
                    "Url has to be valid. Ensure to include the protocol. For example http://google.com",
                    400
                ));
                return;
            }
            $duplicate = $this->repository->findByLong($url);
            if ($duplicate != NULL)
            {
                $this->resolver->resolve(new SimpleResponse(
                    "This url is already shortened by us. ".$duplicate->getShortUrl(),
                    400
                ));
                return;
            }
            try {
                $short = $this->generator->getShort($url);
            } catch (ShouldNotHappenException $e) {
                $this->resolver->resolve(new SimpleResponse(
                    "Could not assign short url.",
                    500
                ));
                return;
            }

            $this->resolver->resolve(new SimpleResponse($this->persist($url, $short)->getShortUrl()));
            return;
        }
    }