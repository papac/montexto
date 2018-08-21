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

        $response = $client->send('22578988547', 'Hello, world');

        $this->assertTrue($response->get('status'));
    }

    public function testSendBulkMessqge()
    {
        $montexto = new \Montexto\Montexto($this->config);

        $client = $montexto->login();

        $this->assertTrue($client->isLogin());

        $response = $client->sendMany(['22578988547', '22578958547'], 'Hello, world. Many');

        $this->assertTrue($response->get('status'));
    }
}