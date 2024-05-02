<?php

namespace App\Tests\Functional\Register;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
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

        self::assertResponseRedirects('/login');

        $entityManager = static::$container->get(EntityManagerInterface::class);
        $userRepository = $entityManager->getRepository(User::class);
        $userData = $userRepository->findOneBy(['email' => $form['registration_form[email]']->getValue()]);

        self::assertNotNull($userData);
    }
}
