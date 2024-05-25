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
    public const NBR_USER = 30;
    public const NBR_COURSE = 30;
    public const NBR_VISIT = 30;
    public const NBR_CATEGORY = 30;
    public const NBR_REQUEST = 30;
    public const NBR_SECTION = 30;

    public function load(ObjectManager $manager): void
    {
        CourseFactory::createMany(self::NBR_COURSE);
        UserFactory::createMany(self::NBR_USER);
        CategoryFactory::createMany(self::NBR_CATEGORY);
        CourseFactory::createMany(self::NBR_COURSE);
        VisitFactory::createMany(self::NBR_VISIT);
        ApplicationFactory::createMany(self::NBR_REQUEST);
        SectionFactory::createMany(self::NBR_SECTION);

        $manager->flush();
    }
}
