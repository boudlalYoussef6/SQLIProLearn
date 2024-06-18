<?php

declare(strict_types=1);

namespace App\Favorite\Command\Doctrine;

use App\Entity\Course;
use App\Entity\Favory;
use App\Favorite\Command\FavoriteCommandInterface;
use App\Favorite\Factory\DefaultFavoriteFactory;
use App\Repository\FavoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractFavoriteDoctrineCommand implements FavoriteCommandInterface
{
    public function __construct(
        protected EntityManagerInterface $manager,
        protected Security $security,
        protected DefaultFavoriteFactory $factory,
    ) {
    }

    public function isFavorite(Course $course, UserInterface $user): bool
    {
        /** @var FavoryRepository $repository */
        $repository = $this->manager->getRepository(Favory::class);

        $favorite = $repository->findOneBy([
            'course' => $course,
            'userIdentifier' => $user->getUserIdentifier(),
        ]);

        return null !== $favorite;
    }
}
