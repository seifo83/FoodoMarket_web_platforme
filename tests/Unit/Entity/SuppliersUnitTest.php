<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Mercurials;
use App\Entity\Products;
use App\Entity\Suppliers;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class SuppliersUnitTest extends TestCase
{
    public function testCreateSupplierIsTrue(): void
    {
        $faker = Factory::create();

        $supplier = new Suppliers();

        $product = new Products();

        $mercurial = new Mercurials();

        $supplier->setName($faker->company())
            ->setAddress($faker->address())
            ->setCity($faker->city())
            ->setCountry($faker->country())
            ->setPhone($faker->phoneNumber())
            ->setEmail($faker->email())
            ->setProductType('fruits_legumes')
            ->setNotes($faker->sentence())
            ->addMercurial($mercurial)
            ->addProduct($product);

        $this->assertSame($supplier->getName(), $supplier->getName());
        $this->assertSame($supplier->getAddress(), $supplier->getAddress());
        $this->assertSame($supplier->getCity(), $supplier->getCity());
        $this->assertSame($supplier->getCountry(), $supplier->getCountry());
        $this->assertSame($supplier->getPhone(), $supplier->getPhone());
        $this->assertSame($supplier->getEmail(), $supplier->getEmail());
        $this->assertSame($supplier->getProductType(), 'fruits_legumes');
        $this->assertSame($supplier->getNotes(), $supplier->getNotes());
        $this->assertSame($supplier->getProducts(), $supplier->getProducts());
        $this->assertSame($supplier->getMercurials(), $supplier->getMercurials());
        $this->assertEmpty($supplier->getId());
        $supplier->removeProduct($product);
        $supplier->removeMercurial($mercurial);
    }
}
