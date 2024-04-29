<?php

namespace App\Tests\Functional\register;

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

        // Génération de données aléatoires
        $phoneNumber = '06' . random_int(10000000, 99999999);
        //$uniqueId = substr(uniqid('user', true), 0, 4);
        //$randomEmail = $uniqueId . '@example.com';

        $form = $crawler->selectButton('Enregistrer')->form();
        $form['registration_form[firstName]'] = $this->generateRandomLetters();
        $form['registration_form[lastName]'] = $this->generateRandomLetters();
        $form['registration_form[email]'] = $this->generateRandomLetters() . '@example.com';
        $form['registration_form[phone]'] = $phoneNumber;
        $form['registration_form[password][first]'] = 'password';
        $form['registration_form[password][second]'] = 'password';

        $client->submit($form);

        $response = $client->getResponse();

        $redirectUrl = $client->getResponse()->headers->get('Location');
        self::assertResponseRedirects('/login');
    }

    public function generateRandomLetters(): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = str_shuffle($alphabet);
        return substr($randomString, 0, 4);
    }
}
