<?php

declare(strict_types=1);

namespace App\Server\Mercure\Publisher;

interface PublisherInterface
{
    public function publish(string|array $topics, string $payload): void;
}
