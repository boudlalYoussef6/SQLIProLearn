<?php

declare(strict_types=1);

namespace App\Service\Indexation;

interface CourseIndexerInterface
{
    public function createNewIndex(string $documentIdentifier, array $data): void;

    public function removeNewIndex(string $documentIdentifier): void;
}
