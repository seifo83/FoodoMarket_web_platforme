<?php

namespace App\Form;

use App\Entity\Suppliers;
use App\Enum\CategoryProductEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuppliersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entrez le nom du fournisseur',
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Entrez l\'adresse',
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Entrez la ville',
                ],
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'Entrez le pays',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Entrez le numéro de téléphone',
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Entrez l\'adresse email',
                ],
            ])
            ->add('product_type', ChoiceType::class, [
                'label' => 'Type de produit',
                'choices' => array_flip(CategoryProductEnum::getTypes()),
                'attr' => [
                    'placeholder' => 'Entrez le type de produit',
                ],
            ])
            ->add('notes', TextType::class, [
                'label' => 'Notes',
                'attr' => [
                    'placeholder' => 'Entrez les notes',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Suppliers::class,
        ]);
    }
}
