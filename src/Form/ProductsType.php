<?php

namespace App\Form;

use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, ['label' => 'Description'])
            ->add('code', TextType::class, ['label' => 'Code'])
            ->add('price', TextType::class, ['label' => 'Prix'])
            ->add('suppliers', ChoiceType::class, [
                'choices' => $options['suppliers'],
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner un fournisseur',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
            'suppliers' => [],
        ]);
    }
}
