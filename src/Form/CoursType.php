<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Course;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->add('description', TextareaType::class, ['required' => false,])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'label', 
            'placeholder' => 'Sélectionnez une catégorie', 
            'label' => 'Catégorie', // Label du champ de sélection
            // Vous pouvez ajouter plus d'options selon vos besoins
            ]);
            
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
