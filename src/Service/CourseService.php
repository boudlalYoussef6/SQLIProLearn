<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\Course;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class CourseService
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager,Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function createCourse(Course $course): void
    {
        $course->setType('sqli');
        $user = $this->security->getUser();
        $userName = $user->getUserIdentifier();
        $author = $this->entityManager->getRepository(Author::class)->findOneBy(['name' => $userName]);
        if (!$author) {
            $author = new Author();
            $author->setName($userName);
            $this->entityManager->persist($author);
        }
        $course->setAuthor($author);
        $this->entityManager->persist($course);
        $this->entityManager->flush();
    }
}






