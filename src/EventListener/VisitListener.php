<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Visit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

final class VisitListener
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        $user = $this->security->getUser();

        if ($user) {
            $visit = new Visit();
            $visit->setDateVisit(new \DateTimeImmutable());
            $visit->setVisiter($user->getUserIdentifier());

            $this->entityManager->persist($visit);
            $this->entityManager->flush();
        }
    }
}
