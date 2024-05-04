<?php

namespace App\Service;

use App\Entity\Suppliers;

class ProcessFilesImportService implements ProcessFilesImportServiceInterface
{
    public function __construct(private ProductImportServiceInterface $productImportService)
    {
    }

    /**
     * @param string $filePath
     * @param string $fileName
     * @param Suppliers $suppliers
     * @return void
     */
    public function processFile(string $filePath, string $fileName, Suppliers $suppliers): void
    {
        $file = fopen($filePath, 'r');

        if ($file) {
            while (!feof($file)) {
                $data = fgetcsv($file, 1000, ',');

                if (count($data) > 0) {
                    $product['description'] = $data[0];
                    $product['code'] = (string) $data[1];
                    $product['price'] = (float) $data[2];
                    dump(empty($product['code']));
                    dump($product);
                    $this->productImportService->importProduct($fileName, $suppliers, $product);
                }
            }
            fclose($file);
        }
    }
}
