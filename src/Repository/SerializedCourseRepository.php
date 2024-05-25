<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SerializedCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SerializedCourse>
 *
 * @method SerializedCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerializedCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerializedCourse[]    findAll()
 * @method SerializedCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerializedCourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerializedCourse::class);
    }

    //    /**
    //     * @return SerializedCourse[] Returns an array of SerializedCourse objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SerializedCourse
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
