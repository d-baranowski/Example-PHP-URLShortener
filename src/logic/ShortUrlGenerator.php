<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 24/05/2017
     * Time: 10:24
     */

    namespace net\devtales\logic;

    interface iShortUrlGenerator
    {
        public function getShort($long, $i = 0);
    }

    class ShortUrlGenerator
    {
        private $repository;
        private $host;
        public function __construct(iUrlMapRepository $repository, string $host)
        {
            $this->repository = $repository;
            $this->host = $host;
        }

        public function getShort($long, $i = 0)
        {
            if ($i > 10)
            {
                throw new ShouldNotHappenException("Failed to generate new random short url 10 times");
            }
            $shortUrl = 'http://'.$this->host.'/'.hash('adler32', $long.$i.$i*$i.$i*$i*$i);
            $duplicate = $this->repository->findByShort($shortUrl);
            if ($duplicate != NULL)
            {
                return $this->getShort($long, $i+1);
            }
            return $shortUrl;
        }
    }
    use net\devtales\repositories\iUrlMapRepository;
    use PHPStan\ShouldNotHappenException;