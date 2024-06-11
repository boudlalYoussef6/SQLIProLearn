<?php

declare(strict_types=1);

namespace App\Service\Indexation;

use App\Transformer\CourseAdapterInterface;
use App\Entity\Course;
use Elastica\Index;
use FOS\ElasticaBundle\Index\IndexManager;
class CourseIndexer implements CourseIndexerInterface
{
   
    private Index $courseIndex;
    private CourseAdapterInterface $adapter;

    public function __construct(IndexManager $indexManager, CourseAdapterInterface $adapter)
    {
        $this->courseIndex = $indexManager->getIndex('course');  // Use the correct index name here
        $this->adapter = $adapter;
    }

    public function createNewIndex(Course $course): void
    {
        $document = $this->adapter->convert($course);
        $this->courseIndex->addDocument($document);
        $this->courseIndex->refresh();
    }

    public function removeNewIndex(Course $course): void
    {
        $this->courseIndex->deleteById((string) $course->getId());
    }
}
