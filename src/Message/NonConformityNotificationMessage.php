<?php

namespace App\Message;

final class NonConformityNotificationMessage
{
    private string $userEmail;
    private string $supplierEmail;
    private string $fileName;
    private string $error;
    private string $code;
    private string $description;
    private float $price;

    public function __construct(
        string $userEmail,
        string $supplierEmail,
        string $fileName,
        string $error,
        string $code,
        string $description,
        float $price
    ) {
        $this->userEmail = $userEmail;
        $this->supplierEmail = $supplierEmail;
        $this->fileName = $fileName;
        $this->error = $error;
        $this->code = $code;
        $this->description = $description;
        $this->price = $price;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getSupplierEmail(): string
    {
        return $this->supplierEmail;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
