<?php

namespace App\Fetcher;

use App\Entity\Suppliers;

interface SupplierFetcherInterface
{
    /**
     * @return Suppliers[]
     */
    public function getAllSuppliers(): array;

    /**
     * @param string $filter
     * @return Suppliers[]
     */
    public function getSupplierByFilter(string $filter): array;

    /**
     * @param int $supplierId
     * @return Suppliers|null
     */
    public function getSupplierById(int $supplierId): ?Suppliers;
}
