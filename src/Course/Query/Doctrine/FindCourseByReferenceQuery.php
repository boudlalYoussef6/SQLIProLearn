<?php

declare(strict_types=1);

namespace App\Course\Query\Doctrine;

use App\Course\Query\ItemQueryInterface;
use App\Entity\Course;
use App\Service\Indexation\CourseIndexerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsAlias]
final class FindCourseByReferenceQuery extends AbstractDatabaseQuery implements ItemQueryInterface
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly CourseIndexerInterface $indexer,
        #[Autowire(service: 'apcu_cache')]
        private readonly CacheItemPoolInterface $cacheItemPool,
    ) {
        parent::__construct($entityManager);
    }

    public function findItem(string $identifier): ?Course
    {
        $course = $this->entityManager
            ->getRepository(Course::class)
            ->find($identifier);

        $this->indexer->createNewIndex($course);

        $this->cacheItemPool->save($course);

        return $course;
    }
}
