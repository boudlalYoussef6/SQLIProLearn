<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Entity\Favory;
use App\Repository\FavoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    public function isFavorite(int $courseIdentifier, string $userIdentifier): bool
    {
        /** @var FavoryRepository $favoriteRepository */
        $favoriteRepository = $this->manager->getRepository(Favory::class);

        return $favoriteRepository->isFavorite($userIdentifier, $courseIdentifier);
    }
}
