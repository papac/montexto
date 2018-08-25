<?php

namespace Montexto;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;

class Client
{
    use UrlVersionner;

    /**
     * @var array
     */
    private $credentials;

    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * @var string
     */
    private $brand = 'MONTEXTO';

    /**
     * Client constructor.
     * @param array $credentials
     * @param GuzzleClient $client
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;

        $this->client = new GuzzleClient;
    }

    /**
     * Check if client connected
     *
     * @return bool
     */
    public function isLogin()
    {
        if (!$this->credentials['status']) {
            return false;
        }

        return true;
    }

    /**
     * Set the client brand
     * 
     * @param string $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * Send a SMS
     *
     * @param int $number
     * @param string $message
     * @return \Montexto\Response
     * @throws
     */
    public function send($number, $message)
    {
        $response = $this->client->request('POST', $this->buildEndpointUrl('send_single_sms'), [
            'form_params' => $this->formatMessage((array) $number, $message)
        ]);

        return $this->formatResponse($response);
    }

    /**
     * Send many a SMS
     *
     * @param array $number
     * @param string $message
     * @return \Montexto\Response
     * @throws
     */
    public function sendMany(array $number, $message)
    {
        $response = $this->client->request('POST', $this->buildEndpointUrl('send_bulk_sms'), [
            'form_params' => $this->formatMessage($number, $message)
        ]);

        return $this->formatResponse($response);
    }

    /**
     * Get SMS credits
     *
     * @return \Montexto\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCredits()
    {
        $response = $this->client->request('POST', $this->buildEndpointUrl('credits_sms'), [
            'form_params' => $this->tokenizer()
        ]);

        return $this->formatResponse($response);
    }

    /**
     * Get SMS credits
     *
     * @return \Montexto\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getConsumedCredits()
    {
        $response = $this->client->request('POST', $this->buildEndpointUrl('credits_consumed_sms'), [
            'form_params' => $this->tokenizer()
        ]);

        return $this->formatResponse($response);
    }

    /**
     * Get login tokens
     *
     * @return array
     */
    private function tokenizer()
    {
        return [
            'Key_api' => $this->credentials['Key_api'],
            'Token_api' => $this->credentials['Token_api']
        ];
    }

    /**
     * Formate message
     *
     * @param array $number
     * @param string $message
     * @return array
     */
    private function formatMessage($number, $message)
    {
        return [
            'Key_api' => $this->credentials['Key_api'],
            'Token_api' => $this->credentials['Token_api'],
            'Message' => $message,
            'Destinataire' => implode(',', (array) $number),
            'SenderName' => $this->brand
        ];
    }

    /**
     * Format Guzzle http response
     *
     * @param $response
     * @return \Montexto\Response
     */
    private function formatResponse(Response $response)
    {
        $data = json_decode($response->getBody()->getContents(), true);

        return new \Montexto\Response($data);
    }

    /**
     * Get all sended message
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSendedMessages()
    {
        $response = $this->client->request('POST', $this->buildEndpointUrl('messages_sent'), [
            'form_params' => $this->tokenizer()
        ]);

        $data = $this->formatResponse($response);

        return $data;
    }

    /**
     * Expiration date
     *
     * @return mixed
     */
    public function tokenExpiratedDate()
    {
        $this->checkIfHasLogged();

        return $this->credentials['Expiration_date_api'];
    }

    /**
     * Expiration date
     *
     * @return mixed
     */
    public function tokenExpirated()
    {
        $this->checkIfHasLogged();

        $time = strtotime($this->credentials['Expiration_date_api']);

        return $time < time();
    }

    /**
     * Get the request API KEY
     * 
     * @return null|string
     */
    public function getKey()
    {
        $this->checkIfHasLogged();

        return $this->credentials['Key_api'];
    }
    
    /**
     * Get the request Token
     * 
     * @return null|string
     */
    public function getToken()
    {
        $this->checkIfHasLogged();

        return $this->credentials['Token_api'];
    }

    /**
     * Check if the client has logged
     * 
     * @throws \Montexto\Exception\LoginException
     */
    private function checkIfHasLogged()
    {
        if (!$this->isLogin()) {
            throw new \Montexto\Exception\LoginException("The client is not connected", 1);
        }
    }
}