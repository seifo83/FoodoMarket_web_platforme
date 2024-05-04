<?php

namespace App\Tests\Unit\Fetcher;

use App\Fetcher\SupplierFetcher;
use PHPUnit\Framework\TestCase;
use App\Entity\Suppliers;
use App\Repository\SuppliersRepository;

class SupplierFetcherUnitTest extends TestCase
{
    public function testGetSupplierById(): void
    {
        $suppliersRepositoryMock = $this->createMock(SuppliersRepository::class);

        $supplierFetcher = new SupplierFetcher($suppliersRepositoryMock);

        $supplierId = 123;

        $supplier = new Suppliers();

        $suppliersRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $supplierId])
            ->willReturn($supplier);

        $result = $supplierFetcher->getSupplierById($supplierId);

        $this->assertSame($supplier, $result);
    }
}
