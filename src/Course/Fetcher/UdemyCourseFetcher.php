<?php

declare(strict_types=1);

namespace App\Course\Fetcher;

use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UdemyCourseFetcher implements CourseFetcherInterface
{
    private HttpClientInterface $client;

    public function __construct(#[Target('udemy_client')] HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetch(int $id): string
    {
        $response = $this->client->request('GET', 'api-2.0/courses/'.$id);

        return $response->getContent();
    }
}
