<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UdemyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('id', IntegerType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control', 'placeholder' => 'Identifiant'],
        ])
        ->add('category', EntityType::class, [
            'class' => Category::class,
            'choice_label' => 'label',
            'placeholder' => 'Sélectionnez une catégorie',
            'label' => false,
            'attr' => ['class' => 'form-control'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
        ]);
    }
}
