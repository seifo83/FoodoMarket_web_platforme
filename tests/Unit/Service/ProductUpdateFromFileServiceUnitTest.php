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

        $fileName = 'file.csv';
        $productInfoFile['description'] = 'Product description';
        $productInfoFile['code'] = 'ABC123';
        $productInfoFile['price'] = 10.99;
        $product = null;

        $productFetcherMock->expects($this->once())
            ->method('getProductByCode')
            ->with($productInfoFile['code'] )
            ->willReturn($product);

        $entityManagerMock->expects($this->once())
            ->method('persist');

        $entityManagerMock->expects($this->once())
            ->method('flush');

        $productUpdateService->addOrUpdateProductFromImportFile(
            $fileName,
            $supplier,
            $productInfoFile
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

        $fileName = 'file.csv';
        $productInfoFile['description'] = 'New product description';
        $productInfoFile['code'] = 'ABC123';
        $productInfoFile['price'] = 19.99;

        $entityManagerMock->expects($this->once())
            ->method('flush');

        $productUpdateService->updateExistingProduct(
            $fileName,
            $product,
            $supplier,
            $productInfoFile
        );

        $this->assertEquals('New product description', $product->getDescription());
        $this->assertEquals(19.99, $product->getPrice());
    }
}
