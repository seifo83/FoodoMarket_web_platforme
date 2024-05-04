<?php

namespace App\Service;

interface EmailNotificationServiceInterface
{
    public function sendProcessingNotification(
        string $fileName,
        string $userEmail,
        string $supplierEmail,
        string $supplierName
    ): void;

    public function sendCompletionNotification(
        string $fileName,
        string $userEmail,
        string $supplierEmail,
        string $supplierName
    ): void;
}
