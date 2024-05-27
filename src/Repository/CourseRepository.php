<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function __construct(private readonly EntityManagerInterface $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function add(Course $course): void
    {
        $this->registry->persist($course);
        $this->registry->flush();
    }

    public function remove(Course $course): void
    {
        $this->registry->remove($course);
        $this->registry->flush();
    }

    public function update(Course $course): void
    {
        $this->registry->flush();
    }
}
