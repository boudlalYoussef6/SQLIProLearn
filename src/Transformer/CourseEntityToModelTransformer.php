<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Course as CourseEntity;
use App\Normalizer\CourseNormalizer;

class CourseEntityToModelTransformer implements CourseAdapterInterface
{
    public function __construct(private CourseNormalizer $normalizer)
    {
    }

    public function convert(CourseEntity $course): array
    {
        return $this->normalizer->normalize(
            object: $course,
            context: [
                'groups' => ['course:read'],
                'enable_max_depth' => true,
            ],
        );
    }
}
