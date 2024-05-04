<?php

namespace App\Tests\Unit\Service;

use App\Service\ConformityPriceAndCodeProductService;
use PHPUnit\Framework\TestCase;

class ConformityPriceAndCodeProductServiceUnitTest extends TestCase
{
    protected ConformityPriceAndCodeProductService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ConformityPriceAndCodeProductService();
    }

    public function testValidCodeAndPrice(): void
    {
        $code = '123';
        $price = 99.99;

        $errors = $this->service->checkConformityPriceAndCodeProduct($code, $price);

        $this->assertEmpty($errors, 'No errors should be returned for valid code and price.');
    }

    public function testEmptyCode(): void
    {
        $code = ' ';
        $price = 99.99;

        $errors = $this->service->checkConformityPriceAndCodeProduct($code, $price);

        $this->assertContains('Vous avez oublié d\'ajouter le prix ou le code.', $errors, 'An error should be returned for empty code.');
    }

    public function testNegativePrice(): void
    {
        $code = '123';
        $price = -10;

        $errors = $this->service->checkConformityPriceAndCodeProduct($code, $price);

        $this->assertContains('Le prix doit être positif mais inférieur à 1000.', $errors, 'An error should be returned for negative price.');
    }

    public function testHighPrice(): void
    {
        $code = '123';
        $price = 1200;

        $errors = $this->service->checkConformityPriceAndCodeProduct($code, $price);

        $this->assertContains('Le prix doit être positif mais inférieur à 1000.', $errors, 'An error should be returned for high price.');
    }

    public function testLongCode(): void
    {
        $code = '123456789';
        $price = 99.99;

        $errors = $this->service->checkConformityPriceAndCodeProduct($code, $price);

        $this->assertContains('La longueur du code produit ne peut pas dépasser 6 caractères.', $errors, 'An error should be returned for long code.');
    }
}
