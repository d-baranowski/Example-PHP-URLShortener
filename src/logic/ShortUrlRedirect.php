<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 24/05/2017
     * Time: 10:02
     */

    namespace net\devtales\logic;


    use net\devtales\repositories\iUrlMapRepository;

    class ShortUrlRedirect
    {
        private $repository;
        private $host;

        public function __construct(iUrlMapRepository $repository,string $host, string $protocol)
        {
            $this->repository = $repository;
            $this->host = $host;
            $this->protocol = $protocol;
        }

        public function redirectIfShortUrlExits($uri)
        {
            $url = $this->protocol.$this->host.$uri;

            $match = $this->repository->findByShort($url);

            if ($match != NULL)
            {
                header('Location: ' . $match->getLongUrl(), true, 302);
                exit();
            }
        }
    }