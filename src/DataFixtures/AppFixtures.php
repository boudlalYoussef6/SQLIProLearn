<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\ApplicationFactory;
use App\Factory\CategoryFactory;
use App\Factory\CourseFactory;
use App\Factory\SectionFactory;
use App\Factory\UserFactory;
use App\Factory\VisitFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const NBR_USER = 30;
    const NBR_CATEGORY = 30;
    const NBR_SECTION = 30;

    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(self::NBR_USER);
        CategoryFactory::createMany(self::NBR_CATEGORY);
        SectionFactory::createMany(self::NBR_SECTION);

        $manager->flush();
    }
}
