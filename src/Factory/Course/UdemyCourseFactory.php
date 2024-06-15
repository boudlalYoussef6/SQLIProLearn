<?php

declare(strict_types=1);

namespace App\Factory\Course;

use App\Entity\Author;
use App\Entity\Course;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UdemyCourseFactory extends AbstractCourseFactory
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly DecoderInterface $decoder,
    ) {
    }

    public function buildCourseInstance(string $rawData): Course
    {
        return $this->serializer->deserialize(
            $rawData,
            type: Course::class,
            format: 'json',
            context: [
                'groups' => ['course:write'],
            ],
        );
    }

    public function buildAutorInstance(string $rawData): Author
    {
        $decodedCourse = $this->decoder->decode($rawData, format: 'json');

        if (empty($decodedCourse['visible_instructors'])) {
            return (new Author())->setName('N/A');
        }

        $instructorData = $decodedCourse['visible_instructors'][0];
        $author = new Author();
        $author->setName($instructorData['display_name']);

        return $author;
    }
}
