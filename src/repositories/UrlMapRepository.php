<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 24/05/2017
     * Time: 08:03
     */

    namespace net\devtales\repositories;

    use Doctrine\ORM\EntityManagerInterface;
    use UrlMap;

    interface iUrlMapRepository
    {
        public function save(UrlMap $map);
        public function getAll();
        public function findByLong($longUrl);
        public function findByShort($shortUrl);
    }



    class UrlMapRepository implements iUrlMapRepository
    {
        private $entityManager;
        private $repository;
        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->entityManager = $entityManager;
            $this->repository = $entityManager->getRepository('UrlMap');
        }

        public function save(UrlMap $map) : UrlMap
        {
            $this->entityManager->persist($map);
            $this->entityManager->flush();

            return $map;
        }

        public function getAll()
        {
            return $this->repository->findAll();
        }

        public function findByLong($longUrl)
        {
            return $this->repository->findOneBy(array('longUrl' => $longUrl));
        }

        public function findByShort($shortUrl)
        {
            return $this->repository->findOneBy(array('shortUrl' => $shortUrl));
        }

    }