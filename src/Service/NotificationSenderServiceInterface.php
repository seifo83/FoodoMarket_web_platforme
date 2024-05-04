<?php

namespace App\Service;

use App\Entity\Suppliers;

interface NotificationSenderServiceInterface
{
    /**
     * @param string $fileName
     * @param Suppliers $supplier
     * @param string $error
     * @param array $product
     * @return void
     */
    public function sendNonConformityNotification(
        string $fileName,
        Suppliers $supplier,
        string $error,
        array $product
    ): void;
}
