<?php

declare(strict_types=1);

namespace App\Favorite\Factory;

use App\Entity\Course;
use App\Entity\Favory;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultFavoriteFactory extends AbstractFavoriteFactory implements FavoriteManagerInterface
{
    public function createNewInstance(Course $course, UserInterface $user): Favory
    {
        $favorite = new Favory();
        $favorite->setCourse($course);
        $favorite->setUserIdentifier($user->getUserIdentifier());

        return $favorite;
    }

    public function findFavorite(Course $course, UserInterface $user): ?Favory
    {
        $identifier = $user->getUserIdentifier();

        return $this->manager
            ->getRepository(Favory::class)
            ->findOneBy([
                'course' => $course,
                'userIdentifier' => $identifier,
            ]);
    }

    public function add(Course $course, UserInterface $user): void
    {
        $favorite = $this->createNewInstance($course, $user);

        $this->manager->persist($favorite);
        $this->manager->flush();
    }

    public function revoke(Course $course, UserInterface $user): void
    {
        if (($favorite = $this->findFavorite($course, $user)) === null) {
            return;
        }

        $this->manager->remove($favorite);
        $this->manager->flush();
    }
}
