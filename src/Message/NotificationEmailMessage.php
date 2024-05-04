<?php

namespace App\Message;

final class NotificationEmailMessage
{
    private string $fileName;
    private string $userEmail;
    private string $supplierEmail;
    private string $supplierName;
    private string $status;

    public function __construct(
        string $fileName,
        string $userEmail,
        string $supplierEmail,
        string $supplierName,
        string $status
    ) {
        $this->fileName = $fileName;
        $this->userEmail = $userEmail;
        $this->supplierEmail = $supplierEmail;
        $this->supplierName = $supplierName;
        $this->status = $status;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getSupplierEmail(): string
    {
        return $this->supplierEmail;
    }

    public function getSupplierName(): string
    {
        return $this->supplierName;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
