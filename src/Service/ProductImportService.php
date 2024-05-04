<?php

namespace App\Service;

use App\Entity\Suppliers;

class ProductImportService implements ProductImportServiceInterface
{
    public function __construct(
        private ConformityPriceAndCodeProductServiceInterface $conformityPriceAndCodeProduct,
        private ProductUpdateFromFileServiceInterface $productUpdateFromFile,
        private NotificationSenderServiceInterface $notificationSender
    ) {
    }

    /**
     * @param string $fileName
     * @param Suppliers $suppliers
     * @param array $productInfoFile
     * @return void
     */
    public function importProduct(string $fileName, Suppliers $suppliers, array $productInfoFile): void
    {
        $conformity = $this->conformityPriceAndCodeProduct
            ->checkConformityPriceAndCodeProduct($productInfoFile['code'], $productInfoFile['price']);

        if (empty($conformity)) {
            $this->productUpdateFromFile
                ->addOrUpdateProductFromImportFile($fileName, $suppliers, $productInfoFile);
        } else {
            $this->notificationSender
                ->sendNonConformityNotification($fileName, $suppliers, $conformity[0], $productInfoFile);
        }
    }
}
