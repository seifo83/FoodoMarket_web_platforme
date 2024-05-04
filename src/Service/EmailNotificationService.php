<?php

namespace App\Service;

use App\Message\NotificationEmailMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class EmailNotificationService implements EmailNotificationServiceInterface
{
    public string $statusPending = "en cours";
    public string $statusEnd = "terminer";

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function sendProcessingNotification(
        string $fileName,
        string $userEmail,
        string $supplierEmail,
        string $supplierName
    ): void {
        $this->messageBus->dispatch(
            new NotificationEmailMessage(
                $fileName,
                $userEmail,
                $supplierEmail,
                $supplierName,
                $this->statusPending
            )
        );
    }

    public function sendCompletionNotification(
        string $fileName,
        string $userEmail,
        string $supplierEmail,
        string $supplierName
    ): void {
        $this->messageBus->dispatch(
            new NotificationEmailMessage(
                $fileName,
                $userEmail,
                $supplierEmail,
                $supplierName,
                $this->statusEnd
            )
        );
    }
}
