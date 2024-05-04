<?php

namespace App\Tests\Unit\Service;

use App\Entity\Mercurials;
use App\Entity\Suppliers;
use App\Service\MercurialService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class MercurialServiceUnitTest extends TestCase
{
    public function testCreateMercurialFile(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $supplier = new Suppliers();
        $supplier->setName('Supplier Name');

        $mercurialService = new MercurialService($entityManager);

        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->callback(function ($mercurial) use ($supplier) {

                return $mercurial instanceof Mercurials &&
                    $mercurial->getFileName() === "test_file.txt" &&
                    $mercurial->getStatus() === "terminer" &&
                    $mercurial->getSupplier() === $supplier;
            }));

        $entityManager->expects($this->once())
            ->method('flush');

        $mercurialService->createMercurialFile(
            'test_file.txt',
            $supplier
        );

        $this->assertTrue(true);
    }
}
