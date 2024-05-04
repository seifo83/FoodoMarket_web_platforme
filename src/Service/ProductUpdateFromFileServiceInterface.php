<?php

namespace App\Service;

use App\Entity\Suppliers;

interface ProductUpdateFromFileServiceInterface
{
    /**
     * @param Suppliers $suppliers
     * @param string $productDescription
     * @param string $productCode
     * @param float $productPrice
     * @return void
     */
    public function addOrUpdateProductFromImportFile(
        Suppliers $suppliers,
        string $productDescription,
        string $productCode,
        float $productPrice
    ): void;
}
