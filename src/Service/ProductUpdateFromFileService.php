<?php

namespace App\Service;

use App\Entity\Products;
use App\Entity\Suppliers;
use App\Fetcher\ProductFetcherInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProductUpdateFromFileService implements ProductUpdateFromFileServiceInterface
{
    public function __construct(
        private ProductFetcherInterface $productFetcher,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param Suppliers $suppliers
     * @param string $productDescription
     * @param string $productCode
     * @param float $productPrice
     * @return void
     */
    public function addOrUpdateProductFromImportFile(
        Suppliers $suppliers,
        string $productDescription,
        string $productCode,
        float $productPrice
    ): void {
        /** @var Products|null $product */
        $product = $this->productFetcher->getProductByCode($productCode);

        if ($product?->getCode()) {
            $this->updateExistingProduct($product, $productDescription, $productPrice);
        } else {
            $this->addNewProduct($suppliers, $productDescription, $productCode, $productPrice);
        }
    }

    public function updateExistingProduct(Products $product, string $description, float $price): void
    {
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setUpdatedAt();

        $this->entityManager->flush();
    }

    public function addNewProduct(Suppliers $supplier, string $description, string $code, float $price): void
    {
        $product = new Products();
        $product->setDescription($description);
        $product->setCode($code);
        $product->setPrice($price);
        $product->setSuppliers($supplier);
        $product->setCreatedAt();

        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}
