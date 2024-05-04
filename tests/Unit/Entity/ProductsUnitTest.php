<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Products;
use App\Entity\Suppliers;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class ProductsUnitTest extends TestCase
{
    public function testCreateProductIsTrue(): void
    {
        $faker = Factory::create();

        $description = $faker->sentence();
        $code = $faker->bothify('??##??');
        $price = $faker->randomFloat(2, 0, 1000);

        $supplier = new Suppliers();

        $product = new Products();
        $product->setDescription($description);
        $product->setCode($code);
        $product->setPrice($price);
        $product->setSuppliers($supplier);

        $this->assertEquals($description, $product->getDescription());
        $this->assertEquals($code, $product->getCode());
        $this->assertEquals($price, $product->getPrice());
        $this->assertEquals($supplier, $product->getSuppliers());
        $this->assertEmpty($product->getId());
    }
}
