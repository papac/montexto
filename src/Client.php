<?php

namespace Montexto;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;

class Client
{
    use URL;

    /**
     * @var array
     */
    private $credentials;

    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * Client constructor.
     * @param array $credentials
     * @param GuzzleClient $client
     */
    public function __construct($credentials, GuzzleClient $client)
    {
        $this->credentials = $credentials;

        $this->client = $client;
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
            'form_params' => $this->tokenize()
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
            'form_params' => $this->tokenize()
        ]);

        return $this->formatResponse($response);
    }

    /**
     * Get login tokens
     *
     * @return array
     */
    private function tokenize()
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
            'SenderName' => $this->credentials['sendername']
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
            'form_params' => $this->tokenize()
        ]);

        $data = $this->formatResponse($response);

        return $data;
    }

    /**
     * Expiration date
     *
     * @return mixed
     */
    public function expirateDate()
    {
        return $this->credentials['Expiration_date_api'];
    }
}