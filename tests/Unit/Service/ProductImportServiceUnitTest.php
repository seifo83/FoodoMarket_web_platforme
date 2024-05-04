<?php

namespace App\Tests\Unit\Service;

use App\Entity\Suppliers;
use App\Service\ConformityPriceAndCodeProductServiceInterface;
use App\Service\NotificationSenderServiceInterface;
use App\Service\ProductImportService;
use App\Service\ProductUpdateFromFileServiceInterface;
use PHPUnit\Framework\TestCase;

class ProductImportServiceUnitTest extends TestCase
{
    public function testImportProductWithConformity(): void
    {
        $conformityMock = $this->createMock(ConformityPriceAndCodeProductServiceInterface::class);
        $conformityMock->expects($this->once())
            ->method('checkConformityPriceAndCodeProduct')
            ->willReturn([]);

        $productUpdateMock = $this->createMock(ProductUpdateFromFileServiceInterface::class);
        $productUpdateMock->expects($this->once())
            ->method('addOrUpdateProductFromImportFile');

        $notificationSenderMock = $this->createMock(NotificationSenderServiceInterface::class);
        $notificationSenderMock->expects($this->never())
            ->method('sendNonConformityNotification');

        $productImportService = new ProductImportService($conformityMock, $productUpdateMock, $notificationSenderMock);

        $productImportService->importProduct('testFile', new Suppliers(), ['code' => '12345', 'price' => 50]);

        $this->assertTrue(true, 'La méthode addOrUpdateProductFromImportFile doit être appelée');
        $this->assertFalse(false, 'La méthode sendNonConformityNotification ne doit pas être appelée');
    }

    public function testImportProductWithNonConformity(): void
    {
        $conformityMock = $this->createMock(ConformityPriceAndCodeProductServiceInterface::class);
        $conformityMock->expects($this->once())
            ->method('checkConformityPriceAndCodeProduct')
            ->willReturn(['Non-conformité détectée']);

        $productUpdateMock = $this->createMock(ProductUpdateFromFileServiceInterface::class);
        $productUpdateMock->expects($this->never())
            ->method('addOrUpdateProductFromImportFile');

        $notificationSenderMock = $this->createMock(NotificationSenderServiceInterface::class);
        $notificationSenderMock->expects($this->once())
            ->method('sendNonConformityNotification');

        $productImportService = new ProductImportService($conformityMock, $productUpdateMock, $notificationSenderMock);

        $productImportService->importProduct('testFile', new Suppliers(), ['code' => '12345', 'price' => 5000]);

        $this->assertFalse(false, 'La méthode addOrUpdateProductFromImportFile ne doit pas être appelée');
        $this->assertTrue(true, 'La méthode sendNonConformityNotification doit être appelée');
    }
}
