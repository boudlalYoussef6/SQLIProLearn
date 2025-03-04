<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Media;
use App\Form\Type\InputTagType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class)
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'label',
                'placeholder' => 'Sélectionnez une catégorie',
                'label' => 'Catégorie',
            ])
            ->add('tags', InputTagType::class)
            ->add('videoPath', FileType::class, [
                'label' => 'Vidéo',
                'required' => false,
                'help' => 'Les seuls types de vidés autorisés sont video/mpeg, video/webm et video/mp4. la taille de la vidéo ne doit pas dépasser 5 Mo',
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['video/mp4', 'video/webm', 'video/mpeg'],
                    ]),
                ],
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
                'constraints' => [
                    new Assert\Valid(),
                ],
            ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            /** @var Course $course */
            $course = $event->getForm()->getData();

            $data = $event->getData();

            if (empty($data['attachments'])) {
                return;
            }

            foreach ($data['attachments'] as $attachment) {
                if (empty($attachment['attachmentFile'])) {
                    continue;
                }

                $media = new Media();
                $media->setCourse($course)
                    ->setAttachmentFile($attachment['attachmentFile']);
                $course->addMedia($media);
            }

            $event->getForm()->setData($course);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
