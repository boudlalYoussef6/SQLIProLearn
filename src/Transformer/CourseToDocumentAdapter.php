<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Course;
use Elastica\Document;

class CourseToDocumentAdapter implements CourseAdapterInterface
{
    public function convert(Course $course): object
    {
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
