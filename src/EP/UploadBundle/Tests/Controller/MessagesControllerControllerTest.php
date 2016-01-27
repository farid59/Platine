<?php

namespace EP\UploadBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessagesControllerControllerTest extends WebTestCase
{
    public function testMessages()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/messages');
    }

    public function testSendmessage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/send');
    }

    public function testMessage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/message');
    }

}
