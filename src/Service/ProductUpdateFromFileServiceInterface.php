<?php

namespace App\Service;

use App\Entity\Suppliers;

interface ProductUpdateFromFileServiceInterface
{
    /**
     * @param string $fileName
     * @param Suppliers $suppliers
     * @param array $productInfoFile
     * @return void
     */
    public function addOrUpdateProductFromImportFile(
        string $fileName,
        Suppliers $suppliers,
        array $productInfoFile
    ): void;
}
