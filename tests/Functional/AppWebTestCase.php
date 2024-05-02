<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppWebTestCase extends WebTestCase
{
    public const EMAIL_USER = 'test@example.com';
    public const PASSWORD_USER= 'password';

    protected static function loginUser(KernelBrowser $client): void
    {
        $crawler = $client->request('GET', '/login');

        $entityManager = static::$container->get('doctrine')->getManager();
        $userRepository = $entityManager->getRepository(User::class);

        /** @var User|null $user */
        $user = $userRepository->findOneBy(['email' => self::EMAIL_USER]);

        if (null === $user) {
            throw new \RuntimeException('Aucun utilisateur trouvé avec cet e-mail.');
        }

        $form = $crawler->selectButton('Connexion')->form();
        $form['email'] = $user->getEmail() ?? '';
        $form['password'] = self::PASSWORD_USER;
        $client->submit($form);
    }
}
