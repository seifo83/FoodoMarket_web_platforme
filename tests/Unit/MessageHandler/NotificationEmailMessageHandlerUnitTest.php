<?php

namespace App\Tests\Unit\MessageHandler;

use App\Message\NotificationEmailMessage;
use App\MessageHandler\NotificationEmailMessageHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class NotificationEmailMessageHandlerUnitTest extends TestCase
{
    /**
     * @throws TransportExceptionInterface
     */
    public function testInvoke(): void
    {
        $mailer = $this->createMock(MailerInterface::class);

        $mailer->expects($this->once())
            ->method('send');

        $handler = new NotificationEmailMessageHandler($mailer);

        $message = new NotificationEmailMessage(
            'test_file.csv',
            'user@example.com',
            'supplier@example.com',
            'Supplier Name',
            'status'
        );

        $handler->__invoke($message);

        $this->addToAssertionCount(1);
    }
}
