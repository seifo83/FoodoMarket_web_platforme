<?php

namespace App\Tests\Functional\register;

use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerFunctionalTest extends WebTestCase
{
    /**
     * @throws \Exception
     */
    public function testRegisterFormSubmission(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        self::assertResponseIsSuccessful();

        $faker = Factory::create();

        $form = $crawler->selectButton('Enregistrer')->form();
        $form['registration_form[firstName]'] = $faker->firstName();
        $form['registration_form[lastName]'] = $faker->lastName();
        $form['registration_form[email]'] = $faker->email();
        $form['registration_form[phone]'] = $faker->phoneNumber();
        $form['registration_form[password][first]'] = 'password';
        $form['registration_form[password][second]'] = 'password';

        $client->submit($form);

        $response = $client->getResponse();
        $redirectUrl = $client->getResponse()->headers->get('Location');

        self::assertResponseRedirects('/login');
    }
}
