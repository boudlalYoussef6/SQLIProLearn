<?php

declare(strict_types=1);

namespace App\Service\Indexation;

use App\Entity\Course;
use Elastica\Document;
use FOS\ElasticaBundle\Elastica\Index;

class CourseIndexer implements CourseIndexerInterface
{
    public function __construct(private readonly Index $courseIndex)
    {
    }

    public function createNewIndex(Course $course): void
    {
        $document = new Document(
            $course->getId(),
            [
                'id' => $course->getId(),
                'label' => $course->getLabel(),
                'description' => $course->getDescription(),
                'category' => $course->getCategory() ? [
                    'id' => $course->getCategory()->getId(),
                    'name' => $course->getCategory()->getLabel(),
                ] : null,
            ]
        );

        $this->courseIndex->addDocument($document);
        $this->courseIndex->refresh();
    }

    public function removeNewIndex(Course $course): void
    {
        $this->courseIndex->deleteById($course->getId());
    }
}
