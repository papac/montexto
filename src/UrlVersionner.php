<?php

namespace Montexto;

trait UrlVersionner
{
    /**
     * The API version
     *
     * @var string
     */
    private $version = 'v1';

    /**
     * The api base endpoint
     *
     * @var string
     */
    private $uri = 'https://api.montexto.pro';

    /**
     * Build the endpoint url
     *
     * @param string $query
     * @return string
     */
    private function buildEndpointUrl($query = '/')
    {
        return $this->uri.'/'.$this->version.'/'.trim($query, '/');
    }

    /**
     * Set the api version
     *
     * @param $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Set base url
     *
     * @param $url
     */
    public function setBaseurl($url)
    {
        $this->uri = $url;
    }
}