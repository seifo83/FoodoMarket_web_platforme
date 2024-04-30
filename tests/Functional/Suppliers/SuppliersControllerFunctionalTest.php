<?php

namespace App\Tests\Functional\Suppliers;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SuppliersControllerFunctionalTest extends WebTestCase
{
    public function testInfoSuppliers(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/suppliers');

        self::assertResponseIsSuccessful();
    }

    public function testAddNewSupplier(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/suppliers/new');

        self::assertResponseIsSuccessful();

        $faker = Factory::create();

        $form = $crawler->selectButton('Ajouter')->form();
        $form['suppliers[name]'] = $faker->company();
        $form['suppliers[address]'] = $faker->address();
        $form['suppliers[city]'] = $faker->city();
        $form['suppliers[country]'] = $faker->country();
        $form['suppliers[phone]'] = $faker->phoneNumber();
        $form['suppliers[email]'] = $faker->email();
        $form['suppliers[product_type]'] = 'fruits_legumes';
        $form['suppliers[notes]'] = $faker->sentence();

        $client->submit($form);

        $response = $client->getResponse();
        $redirectUrl = $client->getResponse()->headers->get('Location');

        self::assertResponseRedirects('/suppliers');
    }

    public function testFilterSuppliers(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/suppliers/search', ['filter' => 'test']);

        self::assertResponseIsSuccessful();

        $crawler = $client->getCrawler();

        self::assertStringContainsString('test', $crawler->text());
    }
}
