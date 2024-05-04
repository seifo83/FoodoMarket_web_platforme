<?php

namespace App\Service;

use App\Entity\Suppliers;

class ProcessFilesImportService implements ProcessFilesImportServiceInterface
{
    public function __construct(private ProductUpdateFromFileServiceInterface $productUpdateFromFile)
    {
    }

    /**
     * @param string $filePath
     * @param Suppliers $suppliers
     * @return void
     */
    public function processFile(string $filePath, Suppliers $suppliers): void
    {
        $file = fopen($filePath, 'r');

        if ($file) {
            while (!feof($file)) {
                $data = fgetcsv($file, 1000, ',');

                if (count($data) > 0) {
                    $productDescription = $data[0];
                    $productCode = (string) $data[1];
                    $productPrice = (float) $data[2];

                    $this->productUpdateFromFile
                        ->addOrUpdateProductFromImportFile(
                            $suppliers,
                            $productDescription,
                            $productCode,
                            $productPrice
                        );
                }
            }

            fclose($file);
        }
    }
}
