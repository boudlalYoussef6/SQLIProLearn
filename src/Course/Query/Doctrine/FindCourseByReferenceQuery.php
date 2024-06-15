<?php

declare(strict_types=1);

namespace App\Course\Query\Doctrine;

use App\Course\Query\ItemQueryInterface;
use App\Entity\Course;
use App\Service\Indexation\CourseIndexerInterface;
use App\Transformer\CourseAdapterInterface;
use App\Transformer\CourseEntityToModelTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsAlias]
final class FindCourseByReferenceQuery extends AbstractDatabaseQuery implements ItemQueryInterface
{
    private readonly CourseAdapterInterface $adapter;

    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly CourseIndexerInterface $indexer,
        #[Autowire(service: CourseEntityToModelTransformer::class)]
        CourseAdapterInterface $adapter,
    ) {
        parent::__construct($entityManager);
        $this->adapter = $adapter;
    }

    public function findItem(string $identifier): mixed
    {
        $course = $this->entityManager
            ->getRepository(Course::class)
            ->find($identifier);

        $normalizedCourse = $this->adapter->convert($course);

        $this->indexer->createNewIndex($identifier, $normalizedCourse);

        return $normalizedCourse;
    }
}
