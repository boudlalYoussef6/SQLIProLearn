<?php

namespace App\Service;

use App\Entity\Course;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\UdemyApiClientInterface;

class UdemyDeserializationService 
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function deserializeCourse(string $data): Course
    {
        return $this->serializer->deserialize($data, Course::class, 'json');
    }

}