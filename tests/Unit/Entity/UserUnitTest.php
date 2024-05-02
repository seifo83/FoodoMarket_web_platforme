<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Suppliers;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testCreateUserIsTrue(): void
    {
        $user =new User();

        $supplier = new Suppliers();

        $user->setEmail('true@test.com')
            ->setFirstName('prenom')
            ->setLastName('nom')
            ->setPassword('password')
            ->setPhone('0606543467')
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt()
            ->addSupplier($supplier);

        $this->assertSame($user->getEmail(), 'true@test.com');
        $this->assertSame('prenom', $user->getFirstName());
        $this->assertSame($user->getLastName(), 'nom');
        $this->assertSame($user->getPassword(), 'password');
        $this->assertSame($user->getPhone(), '0606543467');
        $this->assertSame($user->getRoles(), ['ROLE_USER']);
        $this->assertSame($user->getUserIdentifier(), $user->getEmail());
        $this->assertSame($user->getUsername(), 'true@test.com');
        $this->assertNotEmpty($user->getCreatedAt());
        $this->assertNull($user->getSalt());
        $this->assertNotEmpty($user->getSuppliers());
        $user->eraseCredentials();
        $user->removeSupplier($supplier);
    }

    public function testAddUserWithFalseInformation(): void
    {
        $user =new User();

        $user->setEmail('true@test.com')
            ->setFirstName('prenom')
            ->setLastName('nom')
            ->setPassword('password')
            ->setPhone('0606543467');

        $this->assertNotSame('false@test.com', $user->getEmail());
        $this->assertNotSame('false', $user->getFirstName());
        $this->assertNotSame('false', $user->getLastName());
        $this->assertNotSame('false', $user->getPassword());
        $this->assertNotSame('0606111467', $user->getPhone());
        $this->assertEmpty($user->getId());
    }
}
