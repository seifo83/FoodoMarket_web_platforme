<?php

namespace App\Tests\Functional\Mercurials;

use App\Repository\SuppliersRepository;
use App\Tests\Functional\AppWebTestCase;
use Doctrine\ORM\EntityManagerInterface;

class MercurialsControllerFunctionalTest extends AppWebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        $this->entityManager = static::$container->get(EntityManagerInterface::class);
        $this->suppliersRepository = static::$container->get(SuppliersRepository::class);

    }
    public function testShowImportInterface(): void
    {
        $crawler = $this->client->request('GET', '/import/interface');

        self::assertResponseIsSuccessful();

        self::assertSelectorTextContains('h1', 'Importation Mercuriales');
    }
}
