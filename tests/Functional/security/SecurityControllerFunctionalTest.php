<?php

namespace App\Tests\Functional\security;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerFunctionalTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        self::assertResponseIsSuccessful();

        self::assertSelectorTextContains('h1.title', 'Connexion');

    }

    public function testLogout(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $entityManager = static::$container->get('doctrine')->getManager();
        $userRepository = $entityManager->getRepository(User::class);

        /** @var User|null $user */
        $user = $userRepository->findOneBy(['email' => 'test@example.com']);

        if (null === $user) {
            throw new \RuntimeException('Aucun utilisateur trouvé avec cet e-mail.');
        }

        $form = $crawler->selectButton('Connexion')->form();
        $form['email'] = $user->getEmail() ?? '';
        $form['password'] = 'password';
        $client->submit($form);

        self::assertResponseRedirects('/home');

        $client->request('GET', '/logout');

        $crawler = $client->followRedirect();
        self::assertSelectorTextContains('h1', 'Bienvenue sur FoodoMarket');
    }
}
