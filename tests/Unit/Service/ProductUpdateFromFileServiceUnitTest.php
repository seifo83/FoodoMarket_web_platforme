<?php

namespace App\Tests\Unit\Service;

use App\Entity\Products;
use PHPUnit\Framework\TestCase;
use App\Service\ProductUpdateFromFileService;
use App\Entity\Suppliers;
use App\Fetcher\ProductFetcherInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProductUpdateFromFileServiceUnitTest extends TestCase
{
    public function testAddOrUpdateProductFromImportFile(): void
    {
        $productFetcherMock = $this->createMock(ProductFetcherInterface::class);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $supplier = new Suppliers();

        $productUpdateService = new ProductUpdateFromFileService($productFetcherMock, $entityManagerMock);

        $productCode = 'ABC123';
        $product = null;

        $productFetcherMock->expects($this->once())
            ->method('getProductByCode')
            ->with($productCode)
            ->willReturn($product);

        $entityManagerMock->expects($this->once())
            ->method('persist');

        $entityManagerMock->expects($this->once())
            ->method('flush');

        $productUpdateService->addOrUpdateProductFromImportFile(
            $supplier,
            'Product description',
            $productCode,
            10.99
        );

        $this->addToAssertionCount(1);
    }

    public function testUpdateExistingProduct(): void
    {
        $productFetcherMock = $this->createMock(ProductFetcherInterface::class);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $supplier = new Suppliers();

        $productUpdateService = new ProductUpdateFromFileService($productFetcherMock, $entityManagerMock);

        $product = new Products();

        $entityManagerMock->expects($this->once())
            ->method('flush');

        $productUpdateService->updateExistingProduct(
            $product,
            'New product description',
            19.99
        );

        $this->assertEquals('New product description', $product->getDescription());
        $this->assertEquals(19.99, $product->getPrice());
    }
}
