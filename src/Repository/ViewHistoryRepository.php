<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ViewHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ViewHistory>
 *
 * @method ViewHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ViewHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ViewHistory[]    findAll()
 * @method ViewHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViewHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ViewHistory::class);
    }

    public function findLastVisitedCoursesForUser(string $systemUsername, int $limit = 4): array
    {
        // Sélectionner les 4 derniers enregistrements pour l'utilisateur spécifié
        return $this->createQueryBuilder('vh')
            ->where('vh.user = :systemUsername')
            ->orderBy('vh.dateView', 'DESC')
            ->setMaxResults($limit)
            ->setParameter('systemUsername', $systemUsername)
            ->getQuery()
            ->getResult();
    }
}
