<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Course;
use Elastica\Document;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias]
class CourseToDocumentAdapter implements CourseAdapterInterface
{
    public function convert(Course $course): array
    {
        return [
            'label' => $course->getLabel(),
            'description' => $course->getDescription(),
            'category' => $course->getCategory() ? [
                'id' => $course->getCategory()->getId(),
                'label' => $course->getCategory()->getLabel(),
            ] : null,
        ];

        return new Document(
            (string) $course->getId(),
            [
                'label' => $course->getLabel(),
                'description' => $course->getDescription(),
                'category' => $course->getCategory() ? [
                    'id' => $course->getCategory()->getId(),
                    'label' => $course->getCategory()->getLabel(),
                ] : null,
            ]
        );
    }
}
