<?php

declare(strict_types=1);

namespace App\Favorite\Query;

use Symfony\Component\Security\Core\User\UserInterface;

interface CollectionFavoritesInterface
{
    public function all(UserInterface $user): array;
}
