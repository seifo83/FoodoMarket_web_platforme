<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerFunctionalTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $this->assertSelectorTextContains('h1', 'Bienvenue sur FoodoMarket');
        $this->assertResponseIsSuccessful();

    }
}
