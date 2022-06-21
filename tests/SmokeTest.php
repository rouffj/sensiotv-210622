<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider myPages
     */
    public function testMainPages(string $path, int $statusCode): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $path);
        $this->assertEquals($statusCode, $client->getResponse()->getStatusCode());
    }

    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'SensioTV+');
    }

    public function myPages(): \Generator
    {
        yield ['/', 200];
        yield ['/register', 200];
        //yield ['/admin/users', 301]; // should redirect to login page
    }
}