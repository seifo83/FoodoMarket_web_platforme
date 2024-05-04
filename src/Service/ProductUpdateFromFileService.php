<?php

namespace App\Service;

use App\Entity\Products;
use App\Entity\Suppliers;
use App\Entity\User;
use App\Fetcher\ProductFetcherInterface;
use App\Message\NonConformityNotificationMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductUpdateFromFileService implements ProductUpdateFromFileServiceInterface
{
    public function __construct(
        private ProductFetcherInterface $productFetcher,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param string $fileName
     * @param Suppliers $suppliers
     * @param array $productInfoFile
     * @return void
     */
    public function addOrUpdateProductFromImportFile(
        string $fileName,
        Suppliers $suppliers,
        array $productInfoFile,
    ): void {

        $product = $this->productFetcher->getProductByCode($productInfoFile['code']);



        if (null !== $product) {
            $this->updateExistingProduct($fileName, $product, $suppliers, $productInfoFile);
        } else {
            $this->addNewProduct($fileName, $suppliers, $productInfoFile);
        }
    }

    /**
     * @param string $fileName
     * @param Products $product
     * @param Suppliers $supplier
     * @param $productInfoFile
     * @return void
     */
    public function updateExistingProduct(
        string $fileName,
        Products $product,
        Suppliers $supplier,
        $productInfoFile
    ): void {
            $product->setDescription($productInfoFile['description']);
            $product->setPrice($productInfoFile['price']);
            $product->setUpdatedAt();

            $this->entityManager->flush();
    }

    /**
     * @param string $fileName
     * @param Suppliers $supplier
     * @param array $productInfoFile
     * @return void
     */
    public function addNewProduct(string $fileName, Suppliers $supplier, array $productInfoFile): void
    {
            $product = new Products();
            $product->setDescription($productInfoFile['description']);
            $product->setCode($productInfoFile['code']);
            $product->setPrice($productInfoFile['price']);
            $product->setSuppliers($supplier);
            $product->setCreatedAt();

            $this->entityManager->persist($product);
            $this->entityManager->flush();
    }
}
