<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
{
    // \xampp\php\php bin/phpunit --testdox
    public function testDemo()
    {
        $client = self::createClient();

        $crawler = $client->request('GET', "/testDemo");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains("Symfony", $crawler->filter('#testable em')->text());
    }
    public function testJson()
    {
        $client = self::createClient();

        $client->request('GET', "/testDemo/42");
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $array = json_decode($response->getContent(), true);
        $this->assertEquals(42, count($array));
        $this->assertTrue(isset($array[0]["name"]));
        $this->assertEquals("Bill 2", $array[2]["name"]);
    }
}
