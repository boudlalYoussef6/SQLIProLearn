<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UdemyApiClient
{
    private HttpClientInterface $client;


    public function __construct(#[Target("udemy_client")] HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getCourses(): array
    {
        $response = $this->client->request('GET', 'api-2.0/courses/');

        return $response->toArray();
    }

    public function getCourseById(int $id): string
    {
        $response = $this->client->request('GET', 'api-2.0/courses/'.$id);

        return $response->getContent();
    }
}
