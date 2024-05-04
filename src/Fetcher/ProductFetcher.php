<?php

namespace App\Fetcher;

use App\Entity\Products;
use App\Repository\ProductsRepository;

class ProductFetcher implements ProductFetcherInterface
{
    public function __construct(private ProductsRepository $productsRepository)
    {
    }

    /**
     * @return Products[]
     */
    public function getAllProducts(): array
    {
        return $this->productsRepository->findAll();
    }

    /**
     * @param string $codeProduct
     * @return Products|null
     */
    public function getProductByCode(string $codeProduct): ?Products
    {
        return $this->productsRepository->findOneBy(['code' => $codeProduct]);
    }


    /**
     * @param string $filter
     * @return Products[]
     */
    public function getProductByDescriptionOrCode(string $filter): array
    {
        return $this->productsRepository->findByDescriptionOrCode($filter);
    }
}
