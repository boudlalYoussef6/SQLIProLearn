<?php

declare(strict_types=1);

namespace App\Favorite\Query\Doctrine;

use App\Entity\Favory;
use App\Favorite\Query\CollectionFavoritesInterface;
use App\Repository\FavoryRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class GetCollectionFavoritesQuery extends AbstractFavoriteQuery implements CollectionFavoritesInterface
{
    public function all(UserInterface $user): array
    {
        /** @var FavoryRepository $repository */
        $repository = $this->manager->getRepository(Favory::class);

        return $repository->findBy(['userIdentifier' => $user->getUserIdentifier()]);
    }
}
