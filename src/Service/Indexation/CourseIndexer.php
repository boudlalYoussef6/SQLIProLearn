<?php

declare(strict_types=1);

namespace App\Service\Indexation;

use App\Factory\Document\DocumentFactoryInterface;
use Elastica\Index;
use FOS\ElasticaBundle\Index\IndexManager;

class CourseIndexer implements CourseIndexerInterface
{
    private Index $courseIndex;

    public function __construct(IndexManager $indexManager, private readonly DocumentFactoryInterface $documentFactory)
    {
        $this->courseIndex = $indexManager->getIndex('course');
    }

    public function createNewIndex(string $documentIdentifier, array $data): void
    {
        $document = $this->documentFactory->create($documentIdentifier, $data);

        $this->courseIndex->addDocument($document);

        $this->courseIndex->refresh();
    }

    public function removeNewIndex(string $documentIdentifier): void
    {
        $this->courseIndex->deleteById($documentIdentifier);
    }
}
