<?php

class MontextoTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var array
     */
    private $config;

    public function setUp()
    {
        $this->config = require __DIR__.'/config.php';
    }

    public function testLogin()
    {
        $montexto = new \Montexto\Montexto($this->config);

        $client = $montexto->login();

        $this->assertTrue($client->isLogin());
    }

    public function testFailLogin()
    {
        $this->config['password'] = 'password';

        $montexto = new \Montexto\Montexto($this->config);

        $client = $montexto->login();

        $this->assertFalse($client->isLogin());
    }

    public function testSendMessqge()
    {
        $montexto = new \Montexto\Montexto($this->config);

        $client = $montexto->login();

        $this->assertTrue($client->isLogin());

        $response = $client->send($this->config['numbers'][0], 'Hello, world');

        $this->assertTrue($response->get('status'));
    }

    public function testSendBulkMessqge()
    {
        $montexto = new \Montexto\Montexto($this->config);

        $client = $montexto->login();

        $this->assertTrue($client->isLogin());

        $response = $client->sendMany($this->config['numbers'], 'Hello, world. Many');

        $this->assertTrue($response->get('status'));
    }

    public function testGetCredist()
    {
        $montexto = new \Montexto\Montexto($this->config);

        $client = $montexto->login();

        $this->assertTrue($client->isLogin());

        $credits = $client->getCredits();

        $this->assertTrue(is_int($credits));
    }

    public function testGetConsumedCredits()
    {
        $montexto = new \Montexto\Montexto($this->config);

        $client = $montexto->login();

        $this->assertTrue($client->isLogin());

        $credits = $client->getConsumedCredits();

        $this->assertTrue(is_int($credits));
    }

    public function testGetSendedMessages()
    {
        $montexto = new \Montexto\Montexto($this->config);

        $client = $montexto->login();

        $this->assertTrue($client->isLogin());

        $credits = $client->getSendedMessages();

        $this->assertTrue(is_array($credits));
    }
}
