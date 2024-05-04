<?php

namespace App\Service;

use App\Entity\Mercurials;
use App\Entity\Suppliers;
use Doctrine\ORM\EntityManagerInterface;

class MercurialService implements MercurialServiceInterface
{
    public string $statusEnd = "terminer";
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param string $name
     * @param Suppliers $supplier
     * @return void
     */
    public function createMercurialFile(string $name, Suppliers $supplier): void
    {
        $mercurial = new Mercurials();
        $mercurial->setFileName($name);
        $mercurial->setImportDate(new \DateTime());
        $mercurial->setStatus($this->statusEnd);
        $mercurial->setSupplier($supplier);

        $this->entityManager->persist($mercurial);
        $this->entityManager->flush();
    }
}
