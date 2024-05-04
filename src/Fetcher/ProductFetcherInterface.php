<?php

namespace App\Fetcher;

use App\Entity\Products;

interface ProductFetcherInterface
{
    /**
     * @return Products[]
     */
    public function getAllProducts(): array;

    /**
     * @param string $codeProduct
     * @return Products|null
     */
    public function getProductByCode(string $codeProduct): ?Products;

    /**
     * @param string $filter
     * @return Products[]
     */
    public function getProductByDescriptionOrCode(string $filter): array;
}
