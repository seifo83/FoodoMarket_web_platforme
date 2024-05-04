<?php

namespace App\Service;

use App\Entity\Suppliers;

interface ProcessFilesImportServiceInterface
{
    /**
     * @param string $filePath
     * @param Suppliers $suppliers
     * @return void
     */
    public function processFile(string $filePath, Suppliers $suppliers): void;
}
