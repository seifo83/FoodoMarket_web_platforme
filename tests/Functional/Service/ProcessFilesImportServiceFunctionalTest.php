<?php

namespace App\Tests\Functional\Service;

use App\Entity\Suppliers;
use App\Service\ProcessFilesImportService;
use App\Service\ProductUpdateFromFileServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ProcessFilesImportServiceFunctionalTest extends TestCase
{
    public function testProcessFile(): void
    {
        $filePath = './public/mercuriale2.csv';

        if (!file_exists($filePath)) {
            $this->markTestSkipped('Le fichier de test n\'existe pas.');
        }

        $lineCount = count(file($filePath, FILE_SKIP_EMPTY_LINES));

        $productUpdateFromFile = $this->createMock(ProductUpdateFromFileServiceInterface::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $suppliers = new Suppliers();
        $suppliers->setName('Supplier Name');

        $processFilesImportService = new ProcessFilesImportService($productUpdateFromFile);

        $productUpdateFromFile->expects($this->exactly($lineCount))
            ->method('addOrUpdateProductFromImportFile');

        $processFilesImportService->processFile($filePath, $suppliers);

        $this->addToAssertionCount(1);
    }
}
