<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUserRegistration(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        // When errors
        $this->assertSelectorTextContains('h1', 'Create your account');
        $client->submitForm('Register', [
            'user[firstName]' => ''
        ], 'POST');

        $this->assertEquals(2, $client->getCrawler()->filter('.form-error-icon')->count());
        // When success


        $this->assertSelectorTextContains('h1', 'Create your account');
        $client->submitForm('Register', [
            'user[email]' => 'joseph@test.fr',
            'user[password][first]' => 'testtest',
            'user[password][second]' => 'testtest',
            'user[terms]' => true,
        ], 'POST');

        $this->assertEquals(0, $client->getCrawler()->filter('.form-error-icon')->count());
    }
}
