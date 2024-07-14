<?php

declare(strict_types=1);

namespace App\Favorite\Factory;

use App\Entity\Course;
use App\Entity\Favory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractFavoriteFactory
{
    public function __construct(protected readonly EntityManagerInterface $manager)
    {
    }

    abstract public function createNewInstance(Course $course, UserInterface $user): Favory;

    abstract public function findFavorite(Course $course, UserInterface $user): ?Favory;
}
