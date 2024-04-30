<?php

namespace App\Tests\unit\entity;

use App\Entity\Suppliers;
use PHPUnit\Framework\TestCase;

class SuppliersUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $faker = \Faker\Factory::create();

        $supplier = new Suppliers();

        $supplier->setName($faker->company())
            ->setAddress($faker->address())
            ->setCity($faker->city())
            ->setCountry($faker->country())
            ->setPhone($faker->phoneNumber())
            ->setEmail($faker->email())
            ->setProductType('fruits_legumes')
            ->setNotes($faker->sentence());

        $this->assertSame($supplier->getName(), $supplier->getName());
        $this->assertSame($supplier->getAddress(), $supplier->getAddress());
        $this->assertSame($supplier->getCity(), $supplier->getCity());
        $this->assertSame($supplier->getCountry(), $supplier->getCountry());
        $this->assertSame($supplier->getPhone(), $supplier->getPhone());
        $this->assertSame($supplier->getEmail(), $supplier->getEmail());
        $this->assertSame($supplier->getProductType(), 'fruits_legumes');
        $this->assertSame($supplier->getNotes(), $supplier->getNotes());
        $this->assertEmpty($supplier->getId());
    }
}
