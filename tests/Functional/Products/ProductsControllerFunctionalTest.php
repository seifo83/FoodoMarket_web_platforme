<?php

namespace App\Tests\Functional\Products;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use App\Tests\Functional\AppWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
class ProductsControllerFunctionalTest extends AppWebTestCase
{
    private KernelBrowser $client;
    private ?EntityManagerInterface $entityManager = null;
    private ?ProductsRepository $repository = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        $this->entityManager = static::$container->get(EntityManagerInterface::class);

        $this->repository = static::$container->get(ProductsRepository::class);
    }

    public function testListProducts(): void
    {
        $crawler = $this->client->request('GET', '/products');

        self::assertResponseIsSuccessful();
    }

    public function testListProductsWithFilter(): void
    {
        $this->client->request('GET', '/products?filter=a');

        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAddNewProduct(): void
    {
        self::loginUser($this->client);

        $crawler = $this->client->request('GET', '/products/add');
        self::assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=products]')->form([
            'products[description]' => 'Description du produit',
            'products[code]' => '123456',
            'products[price]' => '19.99',
            'products[suppliers]' => 1,
        ]);

        $this->client->submit($form);

        self::assertResponseRedirects('/products');
    }

    public function testShowProduct(): void
    {
        $this->client->request('GET', '/1/product');

        self::assertResponseIsSuccessful();
    }

    public function testEditProduct(): void
    {
        $crawler = $this->client->request('GET', '/1/product/edit');

        self::assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=products]')->form([
            'products[description]' => 'Poire Non EU New Product Description',
            'products[code]' => '444',
            'products[price]' => '44',
        ]);

        $this->client->submit($form);

        self::assertResponseRedirects('/1/product');

        /** @var Products $product */
        $product = $this->entityManager
            ->getRepository(Products::class)
            ->findOneBy(['id' => 1]);

        self::assertNotEmpty($product->getUpdatedAt());
    }

    /**
     * @throws NonUniqueResultException
     */
    public function testDeleteProduct(): void
    {
        $product = $this->repository->findSecondLastProduct();
        $productId = $product->getId();

        $crawler = $this->client->request('POST', "/$productId/product/delete");

        self::assertResponseRedirects('/products');
    }
}
