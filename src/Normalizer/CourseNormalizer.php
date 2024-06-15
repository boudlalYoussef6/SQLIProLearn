<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\Entity\Course;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CourseNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer,
        #[Autowire(param: 'app.media.cloud.public_url')]
        private readonly string $publicBaseUrl,
    ) {
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        // ... build URLs for Minio

        return $data;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Course;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Course::class => true,
        ];
    }
}
