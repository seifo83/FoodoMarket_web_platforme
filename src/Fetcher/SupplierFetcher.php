<?php

namespace App\Fetcher;

use App\Entity\Suppliers;
use App\Repository\SuppliersRepository;

class SupplierFetcher implements SupplierFetcherInterface
{
    public function __construct(private SuppliersRepository $suppliersRepository)
    {
    }

    /**
     * @return Suppliers[]
     */
    public function getAllSuppliers(): array
    {
        return $this->suppliersRepository->findAll();
    }

    /**
     * @param string $filter
     * @return Suppliers[]
     */
    public function getSupplierByFilter(string $filter): array
    {
        return $this->suppliersRepository->findByFilteredSuppliers($filter);
    }

    /**
     * @param int $supplierId
     * @return Suppliers|null
     */
    public function getSupplierById(int $supplierId): ?Suppliers
    {
        return $this->suppliersRepository->findOneBy(['id' => $supplierId]);
    }
}
