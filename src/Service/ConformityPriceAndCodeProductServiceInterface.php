<?php

namespace App\Service;

use Symfony\Component\Messenger\MessageBusInterface;

interface ConformityPriceAndCodeProductServiceInterface
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
    ): array;
}
