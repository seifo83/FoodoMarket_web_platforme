<?php

namespace App\Service;

use App\Entity\Suppliers;
use App\Entity\User;
use App\Message\NonConformityNotificationMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class NotificationSenderService implements NotificationSenderServiceInterface
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }
    /**
     * @param string $fileName
     * @param Suppliers $supplier
     * @param string $error
     * @param array $product
     * @return void
     */
    public function sendNonConformityNotification(string $fileName,
        Suppliers $supplier,
        string $error,
        array $product
    ): void {

        /** @var User $user */
        $user = $supplier->getUser();

        $this->messageBus->dispatch(
            new NonConformityNotificationMessage($user->getEmail(),
                $supplier->getEmail(),
                $fileName,
                $error,
                $product['code'],
                $product['description'],
                $product['price']
            )
        );
    }
}
