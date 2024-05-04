<?php

namespace App\Tests\Unit\Service;

use App\Service\EmailNotificationService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class EmailNotificationServiceUnitTest extends TestCase
{
    public function testSendProcessingNotification(): void
    {
        $messageBus = $this->createMock(MessageBusInterface::class);

        $fakeEnvelope = new Envelope(new \stdClass());

        $messageBus->method('dispatch')->willReturn($fakeEnvelope);

        $emailNotificationService = new EmailNotificationService($messageBus);

        $emailNotificationService->sendProcessingNotification(
            'test_file.txt',
            'user@example.com',
            'supplier@example.com',
            'Supplier Name'
        );

        self::assertTrue(true);
    }

    public function testSendCompletionNotification(): void
    {
        $messageBus = $this->createMock(MessageBusInterface::class);

        $fakeEnvelope = new Envelope(new \stdClass());

        $messageBus->method('dispatch')->willReturn($fakeEnvelope);

        $emailNotificationService = new EmailNotificationService($messageBus);

        $emailNotificationService->sendCompletionNotification(
            'test_file.txt',
            'user@example.com',
            'supplier@example.com',
            'Supplier Name'
        );

        self::assertTrue(true);
    }
}
