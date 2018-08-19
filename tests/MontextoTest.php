<?php

class MontextoTest extends PHPUnit\Framework\TestCase
{
    public function testLogin()
    {
        $montexto = new \Montexto\Montexto([
            'email' => 'dakiafranck@gmail.com',
            'password' => 'Demo@2018!'
        ]);

        $client = $montexto->login();

        $this->assertTrue($client->isLogin());
    }

    public function testFailLogin()
    {
        $montexto = new \Montexto\Montexto([
            'email' => 'dakiafranck@gmail.com',
            'password' => 'Demo@201!'
        ]);

        $client = $montexto->login();

        $this->assertFalse($client->isLogin());
    }

    public function testSendMessqge()
    {
        $montexto = new \Montexto\Montexto([
            'email' => 'dakiafranck@gmail.com',
            'password' => 'Demo@2018!',
            'sendername' => 'MONTEXTO'
        ]);

        $client = $montexto->login();

        $this->assertTrue($client->isLogin());

        $response = $client->send('22549929598', 'Hello, world');

        $this->assertTrue($response->get('status'));
    }

    public function testSendBulkMessqge()
    {
        $montexto = new \Montexto\Montexto([
            'email' => 'dakiafranck@gmail.com',
            'password' => 'Demo@2018!',
            'sendername' => 'MONTEXTO'
        ]);

        $client = $montexto->login();

        $this->assertTrue($client->isLogin());

        $response = $client->sendMany(['22549929598', '22552797005'], 'Hello, world. Many');

        $this->assertTrue($response->get('status'));
    }
}