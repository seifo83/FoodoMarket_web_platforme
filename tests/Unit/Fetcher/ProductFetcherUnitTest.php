<?php

namespace App\Tests\Unit\Fetcher;

use App\Entity\Products;
use App\Fetcher\ProductFetcher;
use App\Repository\ProductsRepository;
use PHPUnit\Framework\TestCase;

class ProductFetcherUnitTest extends TestCase
{
    public function testGetProductByCode(): void
    {
        $productsRepositoryMock = $this->createMock(ProductsRepository::class);

        $productFetcher = new ProductFetcher($productsRepositoryMock);

        $productCode = 'ABC123';

        $product = new Products();
        $product->setCode($productCode);

        $productsRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['code' => $productCode])
            ->willReturn($product);

        $result = $productFetcher->getProductByCode($productCode);

        $this->assertSame($product, $result);
    }
}
