<?php

declare(strict_types=1);

namespace App\Service\Locator\Favorite\Command;

use App\Favorite\Command\Doctrine\AddToFavoriteCommand;
use App\Favorite\Command\Doctrine\RevokeFavoriteCommand;
use App\Favorite\Command\FavoriteCommandInterface;
use App\Service\Locator\AbstractCommandLocator;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class FavoriteCommandLocator extends AbstractCommandLocator implements ServiceSubscriberInterface
{
    public static function getSubscribedServices(): array
    {
        return [
            'add_course_to_favorite_command' => AddToFavoriteCommand::class,
            'revoke_course_from_favorite_command' => RevokeFavoriteCommand::class,
        ];
    }

    public function summon(string $service): FavoriteCommandInterface
    {
        if ($this->container->has($service)) {
            return $this->container->get($service);
        }

        throw new ServiceNotFoundException($service);
    }
}
