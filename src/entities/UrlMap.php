<?php

    /**
     * @Entity @Table(name="urlmaps")
     **/
    class UrlMap
    {
        /** @Id @Column(type="integer") @GeneratedValue **/
        protected $id;
        /** @Column(type="string") **/
        protected $longUrl;
        /** @Column(type="string") **/
        protected $shortUrl;

        /**
         * @return int
         */
        public function getId(): int
        {
            return $this->id;
        }

        /**
         * @return string
         */
        public function getLongUrl(): string
        {
            return $this->longUrl;
        }

        /**
         * @return string
         */
        public function getShortUrl(): string
        {
            return $this->shortUrl;
        }

        /**
         * @param string $longUrl
         */
        public function setLongUrl(string $longUrl)
        {
            $this->longUrl = $longUrl;
        }

        /**
         * @param string $shortUrl
         */
        public function setShortUrl(string $shortUrl)
        {
            $this->shortUrl = $shortUrl;
        }
    }