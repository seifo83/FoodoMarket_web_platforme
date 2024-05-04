<?php

namespace App\Tests\Functional\Service;

use App\Entity\Products;
use App\Entity\Suppliers;
use App\Tests\Functional\AppWebTestCase;
use Doctrine\ORM\EntityManagerInterface;

class ProcessFilesImportServiceFunctionalTest extends AppWebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        $this->entityManager = static::$container->get(EntityManagerInterface::class);
    }

    public function testProcessFile(): void
    {
        $csvContent = "Product1,123,10.99\nProduct2,456,20.99";
        $tempFilePath = tempnam(sys_get_temp_dir(), 'test_');
        file_put_contents($tempFilePath, $csvContent);

        $container = $this->client->getContainer();
        $processFilesImportService = $container->get('App\Service\ProcessFilesImportService');

        $supplier = $this->entityManager
            ->getRepository(Suppliers::class)
            ->findOneBy(['id' => 1]);

        $processFilesImportService->processFile($tempFilePath, 'test.csv', $supplier);

        $product1 = $this->entityManager
            ->getRepository(Products::class)
            ->findOneBy(['code' => '123']);

        $product2 = $this->entityManager
            ->getRepository(Products::class)
            ->findOneBy(['code' => '456']);

        $this->assertNotNull($product1);
        $this->assertEquals('Product1', $product1->getDescription());
        $this->assertEquals(10.99, $product1->getPrice());

        $this->assertNotNull($product2);
        $this->assertEquals('Product2', $product2->getDescription());
        $this->assertEquals(20.99, $product2->getPrice());

        unlink($tempFilePath);
    }
}
