<?php

declare(strict_types=1);

namespace App\Course\Query\Decorator;

use App\Course\Query\ItemQueryInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use Symfony\Contracts\Cache\CacheInterface;

#[AsDecorator(decorates: ItemQueryInterface::class, priority: 1)]
class FindCachedCourseByReferenceQuery implements ItemQueryInterface
{
    private readonly ItemQueryInterface $query;

    public function __construct(
        #[AutowireDecorated]
        ItemQueryInterface $query,
        private readonly CacheInterface $cache,
    ) {
        $this->query = $query;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findItem(string $identifier): mixed
    {
        return $this->cache->get($identifier, function () use ($identifier) {
            return $this->query->findItem($identifier);
        });
    }
}
