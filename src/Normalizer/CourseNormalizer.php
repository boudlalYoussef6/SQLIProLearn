<?php

declare(strict_types=1);

namespace App\Normalizer;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CourseNormalizer
{
    public function __construct(
        #[Autowire(param: 'app.media.cloud.public_url')]
        private readonly string $publicBaseUrl,
    ) {
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): mixed
    {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());

        $normalizer = new Serializer(normalizers: [new ObjectNormalizer($classMetadataFactory)]);

        return $normalizer->normalize($object, $format, $context);
    }
}
