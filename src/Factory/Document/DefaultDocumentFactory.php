<?php

declare(strict_types=1);

namespace App\Factory\Document;

use Elastica\Document;

class DefaultDocumentFactory implements DocumentFactoryInterface
{
    public function create(string $documentIdentifier, array $data): Document
    {
        return new Document($documentIdentifier, $data);
    }
}
