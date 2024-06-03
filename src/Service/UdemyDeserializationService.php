<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;
use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UdemyDeserializationService
{
    public function __construct(private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    public function deserializeCourse(string $data): Course
    {
        $course = $this->serializer->deserialize($data, Course::class, 'json');

        $decodedData = json_decode($data, true);

        if (isset($decodedData['visible_instructors']) && count($decodedData['visible_instructors']) > 0) {
            $instructorData = $decodedData['visible_instructors'][0];
            $author = new Author();
            $author->setName($instructorData['display_name']);

            // Persiste l'auteur dans la base de données
            $this->entityManager->persist($author);
            $this->entityManager->flush();

            // Associe l'auteur au cours
            $course->setAuthor($author);
        }

        return $course;
    }
}
