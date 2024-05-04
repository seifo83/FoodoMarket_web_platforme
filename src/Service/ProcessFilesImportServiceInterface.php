<?php

namespace App\Service;

use App\Entity\Suppliers;

interface ProcessFilesImportServiceInterface
{
    /**
     * @param string $filePath
     * @param string $fileName
     * @param Suppliers $suppliers
     * @return void
     */
    public function processFile(string $filePath, string $fileName, Suppliers $suppliers): void;
}
