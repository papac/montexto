<?php

namespace Montexto;

use GuzzleHttp\Client as GuzzleClient;

class Montexto
{
    use UrlVersionner;

    /**
     * @param array
     */
    private $config;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Client
     */
    private $local_client;

    /**
     * Constructor
     *
     * @param array $config
     * @param $login bool
     */
    public function __construct(array $config, $login = false)
    {
        $config['brand'] = isset($config['brand']) ? $config['brand'] : 'MONTEXTO';
        
        $this->client = new GuzzleClient();

        $this->config = $config;

        if ($login) {
            $this->local_client = $this->login();
        }
    }

    /**
     * Get login client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->local_client;
    }

    /**
     * Make login
     *
     * @throws
     */
    public function login()
    {
        $response = $this->client->request('POST', $this->buildEndpointUrl('login'), [
            'form_params' => $this->credentials()
        ]);

        $credentials = json_decode($response->getBody()->getContents(), true);

        $client = new Client($credentials);

        $client->setBrand($this->config['brand']);

        return $client;
    }

    /**
     * Build credentials
     *
     * @return array
     */
    private function credentials()
    {
        return [
            'Email' => $this->config['email'],
            'Password' => $this->config['password']
        ];
    }
}
