<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Category;
use App\Entity\Course;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class)
            ->add('description', TextareaType::class, ['required' => false])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'label',
                'placeholder' => 'Sélectionnez une catégorie',
                'label' => 'Catégorie',
            ])
            ->add('videoPath', FileType::class, [
                'label' => 'Vidéo',
            ])
            ->add('attachments', CollectionType::class, [
                'entry_type' => MediaType::class,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
                'entry_options' => ['label' => false],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
