<?php
    /**
     * Created by PhpStorm.
     * User: Daniel
     * Date: 24/05/2017
     * Time: 08:03
     */

    namespace net\devtales\repositories;

    interface iUrlMapRepository
    {
        public function save(UrlMap $map);
        public function getAll();
        public function findByLong($longUrl);
    }

    use Doctrine\ORM\EntityManagerInterface;
    use UrlMap;

    class UrlMapRepository implements iUrlMapRepository
    {
        private $entityManager;
        private $repository;
        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->entityManager = $entityManager;
            $this->repository = $entityManager->getRepository('UrlMap');
        }

        public function save(UrlMap $map)
        {
            $this->entityManager->persist($map);
            $this->entityManager->flush();
            return $map->getId();
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