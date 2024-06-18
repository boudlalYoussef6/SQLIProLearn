<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Favory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Favory>
 *
 * @method Favory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favory[]    findAll()
 * @method Favory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favory::class);
    }

    public function isFavorite(string $user, int $courseIdentifier): bool
    {
        $favorites = $this->findFavoriteCourses($user);

        $filtered = \array_filter($favorites, fn (Favory $item) => $item->getCourse()->getId() === $courseIdentifier);

        return !empty($filtered);
    }

    public function findFavoriteCourses(string $userIdentifier): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.userIdentifier = :userIdentifier')
            ->setParameter('userIdentifier', $userIdentifier)
            ->getQuery()
            ->getResult();
    }
}
