<?php

namespace App\MessageHandler;

use App\Message\NotificationEmailMessage;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

final class NotificationEmailMessageHandler implements MessageHandlerInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(NotificationEmailMessage $message): void
    {
        $emailContent = '<p>Bonjour ' . $message->getSupplierName() . ',</p>' .
            '<p>Nous vous informons que le traitement de votre liste mercuriale est 
                <strong>' . $message->getStatus() . '</strong>.</br>
                Veuillez patienter pendant que nous importons et analysons les données du fichier : 
                <strong>' . $message->getFileName() . '</strong>.</p>' .
            '<p>Cordialement,</p>' .
            '<p>Votre entreprise FoodoMarket</p>';

        $email = (new Email())
            ->from($message->getUserEmail())
            ->to($message->getSupplierEmail())
            ->subject('Traitement de la liste mercuriale est ' . $message->getStatus())
            ->html($emailContent);

        // Envoyer l'e-mail
        $this->mailer->send($email);
    }
}
