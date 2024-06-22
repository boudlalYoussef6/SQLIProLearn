<?php

declare(strict_types=1);

namespace App\Favorite\Command\Doctrine;

use App\Entity\Course;

class RevokeFavoriteCommand extends AbstractFavoriteDoctrineCommand
{
    public function execute(Course $course): void
    {
        $user = $this->security->getUser();

        if (!$this->isFavorite($course, $user)) {
            return;
        }

        $this->factory->revoke($course, $user);
    }
}
