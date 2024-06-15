<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\CourseFactory;
use App\Factory\SectionFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public const NBR_USER = 30;
    public const NBR_CATEGORY = 30;
    public const NBR_SECTION = 30;
    public const NBR_COURS = 30;

    public function load(ObjectManager $manager): void
    {
       
        
        CategoryFactory::createMany(self::NBR_CATEGORY);
      

        $manager->flush();
    }
}
