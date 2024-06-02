<?php

declare(strict_types=1);

namespace App\Service;

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
        return $this->serializer->deserialize($data, Course::class, 'json');
    }
}
