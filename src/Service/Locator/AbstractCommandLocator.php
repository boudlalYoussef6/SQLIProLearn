<?php

declare(strict_types=1);

namespace App\Service\Locator;

use Psr\Container\ContainerInterface;

abstract class AbstractCommandLocator
{
    public function __construct(protected readonly ContainerInterface $container)
    {
    }
}
