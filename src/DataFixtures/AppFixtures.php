<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\SectionFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public const NBR_USER = 30;
    public const NBR_CATEGORY = 30;
    public const NBR_SECTION = 30;

    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(self::NBR_USER);
        CourseFactory::createMany(self::NBR_COURS);
        CategoryFactory::createMany(self::NBR_CATEGORY);
        SectionFactory::createMany(self::NBR_SECTION);

        $manager->flush();
    }
}
