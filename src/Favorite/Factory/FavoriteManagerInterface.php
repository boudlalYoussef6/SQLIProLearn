<?php

declare(strict_types=1);

namespace App\Favorite\Factory;

use App\Entity\Course;
use Symfony\Component\Security\Core\User\UserInterface;

interface FavoriteManagerInterface
{
    public function add(Course $course, UserInterface $user): void;

    public function revoke(Course $course, UserInterface $user): void;
}
