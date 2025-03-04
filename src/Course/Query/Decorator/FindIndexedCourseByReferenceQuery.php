<?php

declare(strict_types=1);

namespace App\Course\Query\Decorator;

use App\Course\Query\ItemQueryInterface;
use Elastica\Exception\NotFoundException;
use Elastica\Index;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;

#[AsDecorator(decorates: ItemQueryInterface::class, priority: 2)]
class FindIndexedCourseByReferenceQuery implements ItemQueryInterface
{
    private readonly ItemQueryInterface $query;

    public function __construct(
        #[AutowireDecorated]
        ItemQueryInterface $query,
        private readonly Index $index,
    ) {
        $this->query = $query;
    }

    public function findItem(string $identifier): mixed
    {
        try {
            $response = $this->index->getDocument($identifier);

            return $response->getData();
        } catch (NotFoundException) {
            /* return $this->query->findItem($identifier); */
            return null;
        }
    }
}
