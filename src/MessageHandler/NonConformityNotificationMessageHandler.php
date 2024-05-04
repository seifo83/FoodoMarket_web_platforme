<?php

namespace App\MessageHandler;

use App\Message\NonConformityNotificationMessage;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

final class NonConformityNotificationMessageHandler implements MessageHandlerInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(NonConformityNotificationMessage $message): void
    {

        $emailContent = '<p>Bonjour,</p>' .
            '<p>Nous vous informons que des données non conformes ont été détectées
                lors de l\'importation de votre fichier.</p>' .
            '<p>Voici les détails de la non-conformité :</p>' .
            '<ul>' .
            '<li>Erreur : ' . $message->getError() . '</li>' .
            '<li>Fichier : ' . $message->getFileName() . '</li>' .
            '<li>Code Produit : ' . $message->getCode() . '</li>' .
            '<li>Description Produit : ' . $message->getDescription() . '</li>' .
            '<li>Prix Produit : ' . $message->getPrice() . '</li>' .
            '</ul>' .
            '<p>Veuillez corriger les données et réimporter le fichier.</p>' .
            '<p>Cordialement,</p>' .
            '<p>Votre entreprise FoodoMarket</p>';

        // Créer l'e-mail de notification
        $email = (new Email())
            ->from($message->getUserEmail())
            ->to($message->getSupplierEmail())
            ->subject('Notification de non-conformité détectée')
            ->html($emailContent);

        // Envoyer l'e-mail de notification
        $this->mailer->send($email);
    }
}
