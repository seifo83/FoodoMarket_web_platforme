<?php

namespace App\Service;

use App\Entity\Suppliers;

interface MercurialServiceInterface
{
    /**
     * @param string $name
     * @param Suppliers $supplier
     * @return void
     */
    public function createMercurialFile(string $name, Suppliers $supplier): void;
}
