<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\CourseFactory;
use App\Factory\ApplicationFactory;
use App\Factory\SectionFactory;
use App\Factory\UserFactory;
use App\Factory\VisitFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const NBR_USER = 30;
    const NBR_COURSE = 30;
    const NBR_VISIT = 30;
    const NBR_CATEGORY = 30;
    const NBR_REQUEST = 30;
    const NBR_SECTION = 30;

    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(self::NBR_USER);
        CategoryFactory::createMany(self::NBR_CATEGORY);
        CourseFactory::createMany(self::NBR_COURSE);
        VisitFactory::createMany(self::NBR_VISIT);
        ApplicationFactory::createMany(self::NBR_REQUEST);
        SectionFactory::createMany(self::NBR_SECTION);

        $manager->flush();
    }
}
