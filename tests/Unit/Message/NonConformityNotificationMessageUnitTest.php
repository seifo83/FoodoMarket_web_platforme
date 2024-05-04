<?php

namespace App\Tests\Unit\Message;

use App\Message\NonConformityNotificationMessage;
use PHPUnit\Framework\TestCase;

class NonConformityNotificationMessageHandlerUnitTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        // Données de test
        $userEmail = 'user@example.com';
        $supplierEmail = 'supplier@example.com';
        $fileName = 'test.csv';
        $error = 'Error message';
        $code = '123';
        $description = 'Product description';
        $price = 10.99;

        // Création de l'objet NonConformityNotificationMessage
        $message = new NonConformityNotificationMessage(
            $userEmail,
            $supplierEmail,
            $fileName,
            $error,
            $code,
            $description,
            $price
        );

        // Assertions sur les getters
        $this->assertEquals($userEmail, $message->getUserEmail());
        $this->assertEquals($supplierEmail, $message->getSupplierEmail());
        $this->assertEquals($fileName, $message->getFileName());
        $this->assertEquals($error, $message->getError());
        $this->assertEquals($code, $message->getCode());
        $this->assertEquals($description, $message->getDescription());
        $this->assertEquals($price, $message->getPrice());
    }
}
