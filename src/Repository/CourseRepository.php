<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function add(Course $course): void
    {
        $manager = $this->getEntityManager();

        $manager->persist($course);
        $manager->flush();
    }

    public function remove(Course $course): void
    {
        $manager = $this->getEntityManager();

        $manager->remove($course);
        $manager->flush();
    }

    public function update(Course $course): void
    {
        $manager = $this->getEntityManager();

        $manager->flush();
    }

    /**
     * @return Course[]
     */
    public function findByAuthorName(string $authorName): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.author', 'a')
            ->andWhere('a.name = :authorName')
            ->setParameter('authorName', $authorName)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
