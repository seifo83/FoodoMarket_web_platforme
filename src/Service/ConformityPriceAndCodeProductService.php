<?php

namespace App\Service;

use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class ConformityPriceAndCodeProductService implements ConformityPriceAndCodeProductServiceInterface
{
    /**
     * @param string|null $code
     * @param float|null $price
     * @param MessageBusInterface|null $messageBus
     * @return array
     */
    public function checkConformityPriceAndCodeProduct(
        ?string $code,
        ?float $price,
        MessageBusInterface $messageBus = null
    ): array {
        if ($messageBus === null) {
            $messageBus = new MessageBus();
        }

        $errors = [];

        if (null === $code || null === $price || ' ' === $code || '' === $price) {
            $errors[] = 'Vous avez oublié d\'ajouter le prix ou le code.';
        }


        if ($price <= 0 || $price >= 1000) {
            $errors[] = 'Le prix doit être positif mais inférieur à 1000.';
        }

        if (strlen($code) > 6) {
            $errors[] = 'La longueur du code produit ne peut pas dépasser 6 caractères.';
        }

        return $errors;
    }
}
