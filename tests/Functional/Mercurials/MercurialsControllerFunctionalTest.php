<?php

namespace App\Tests\Functional\Mercurials;

use App\Tests\Functional\AppWebTestCase;

class MercurialsControllerFunctionalTest extends AppWebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }
    public function testShowImportInterface(): void
    {
        $crawler = $this->client->request('GET', '/import/interface');

        self::assertResponseIsSuccessful();

        self::assertSelectorTextContains('h1', 'Importation Mercuriales');
    }
}
