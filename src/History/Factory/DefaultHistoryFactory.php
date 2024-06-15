<?php

declare(strict_types=1);

namespace App\History\Factory;

use App\Entity\Course;
use App\Entity\ViewHistory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class DefaultHistoryFactory extends AbstractDatabaseHistoryFactory
{
    public function __construct(
        private readonly Security $security,
        protected EntityManagerInterface $manager,
    ) {
        parent::__construct($this->manager);
    }

    public function buildHistory(Course $course): ViewHistory
    {
        $userIdentifier = $this->security
            ->getUser()
            ->getUserIdentifier();

        $viewHistory = new ViewHistory();
        $viewHistory->setUser($userIdentifier);
        $viewHistory->setDateView(new \DateTime());

        $viewHistory->setCourse($course);

        return $viewHistory;
    }
}
