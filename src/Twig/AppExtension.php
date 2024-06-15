<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private readonly string $mediaUrl;

    public function __construct(#[Autowire('%app.media.cloud.public_url%')] string $mediaUrl)
    {
        $this->mediaUrl = $mediaUrl;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('generate_cloud_url', [$this, 'encodeUrl']),
        ];
    }

    public function encodeUrl(string $string): string
    {
        return \sprintf('%s/videos/%s', $this->mediaUrl, $string);
    }
}
