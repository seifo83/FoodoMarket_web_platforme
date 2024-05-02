<?php

namespace App\Tests\Functional\Security;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerFunctionalTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    public function testLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');

        self::assertResponseIsSuccessful();

        self::assertSelectorTextContains('h1.title', 'Connexion');

    }

    public function testLogout(): void
    {
        $crawler = $this->client->request('GET', '/login');

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
        $this->client->submit($form);

        self::assertResponseRedirects('/home');

        $this->client->request('GET', '/logout');

        $crawler = $this->client->followRedirect();
        self::assertSelectorTextContains('h1', 'Bienvenue sur FoodoMarket');
    }
}
