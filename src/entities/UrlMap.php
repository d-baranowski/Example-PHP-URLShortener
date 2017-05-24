<?php

    /**
     * @Entity @Table(name="urlmaps")
     **/
    class UrlMap
    {
        /** @Id @Column(type="integer", name="id") @GeneratedValue **/
        protected $id;
        /** @Column(type="string", name="longUrl", length=999, unique=true, nullable=false) **/
        protected $longUrl;
        /** @Column(type="string", name="shortUrl", length=100, unique=true, nullable=false) **/
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