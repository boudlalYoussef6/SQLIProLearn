<?php

declare(strict_types=1);

namespace App\Factory\Document;

use Elastica\Document;

interface DocumentFactoryInterface
{
    public function create(string $documentIdentifier, array $data): Document;
}
