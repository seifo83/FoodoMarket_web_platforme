<?php

namespace App\Tests\Functional\Suppliers;

use App\Tests\Functional\AppWebTestCase;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class SuppliersControllerFunctionalTest extends AppWebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }
    public function testInfoSuppliers(): void
    {
        $crawler = $this->client->request('GET', '/suppliers');

        self::assertResponseIsSuccessful();
    }

    public function testAddNewSupplier(): void
    {
        self::loginUser($this->client);

        $this->client->request('GET', '/suppliers');
        self::assertResponseIsSuccessful();

        $crawler = $this->client->request('GET', '/suppliers/new');
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

        $this->client->submit($form);

        $this->client->followRedirect();

        self::assertRouteSame('app_suppliers');
    }

    public function testSuppliersWithFilter(): void
    {
        $this->client->request('GET', '/suppliers?filter=a');

        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
