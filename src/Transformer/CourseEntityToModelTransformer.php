<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Course as CourseEntity;
use App\Normalizer\CourseNormalizer;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CourseEntityToModelTransformer implements CourseAdapterInterface
{
    public function __construct(
        #[Autowire(service: CourseNormalizer::class)]
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function convert(CourseEntity $course): array
    {
        return $this->normalizer->normalize(
            object: $course,
            context: ['groups' => ['course:read']],
        );
    }
}
