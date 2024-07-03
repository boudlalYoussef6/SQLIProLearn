<?php

declare(strict_types=1);

namespace App\Course\Query\Decorator;

use App\Course\Query\ItemQueryInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

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

    public function findItem(string $identifier): mixed
    {
        return $this->cache->get($identifier, function (ItemInterface $item) use ($identifier) {
            $item->expiresAfter(3600); // expires after 1 hour

            return $this->query->findItem($identifier);
        });
    }
}
