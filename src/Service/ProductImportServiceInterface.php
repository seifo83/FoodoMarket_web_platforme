<?php

namespace App\Service;

use App\Entity\Suppliers;

interface ProductImportServiceInterface
{
    /**
     * @param string $fileName
     * @param Suppliers $suppliers
     * @param array $productInfoFile
     * @return void
     */
    public function importProduct(string $fileName, Suppliers $suppliers, array $productInfoFile): void;

}
