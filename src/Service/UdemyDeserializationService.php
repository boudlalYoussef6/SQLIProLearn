<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Course;
use Symfony\Component\Serializer\SerializerInterface;

class UdemyDeserializationService
{
    public function __construct(private readonly SerializerInterface $serializer){
    }

    public function deserializeCourse(string $data): Course
    {
        return $this->serializer->deserialize($data, Course::class, 'json');
    }
}
