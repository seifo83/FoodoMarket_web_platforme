<?php

namespace App\Tests\unit\register;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\Test\TypeTestCase;

class RegistrationFormTypeUnitTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'test@example.com',
            'phone' => '123456789',
            'password' => [
                'first' => 'password',
                'second' => 'password',
            ],
        ];

        $object = new User();
        $object->setFirstName($formData['firstName']);
        $object->setLastName($formData['lastName']);
        $object->setEmail($formData['email']);
        $object->setPhone($formData['phone']);
        $object->setPassword($formData['password']['first']);

        $form = $this->factory->create(RegistrationFormType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($object, $form->getData());

        $errors = $form->getErrors(true);
        $this->assertCount(0, $errors);
    }
}
