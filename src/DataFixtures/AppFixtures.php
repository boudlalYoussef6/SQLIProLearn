<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public const NBR_CATEGORY = 5;

    public function load(ObjectManager $manager): void
    {
        CategoryFactory::createMany(self::NBR_CATEGORY);

        $manager->flush();
    }
}
